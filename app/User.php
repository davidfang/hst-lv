<?php

namespace App;

use App\Model\Account;
use App\Model\TaobaoPid;
use function foo\func;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * 可以根据多项查找用户
     * @param $login
     * @return User|\Illuminate\Database\Eloquent\Model|\Illuminate\Database\Query\Builder|null|object
     */
    public function findForPassport($username)
    {
        return $this->orWhere('email', $username)->orWhere('mobile', $username)->first();
    }

    /**
     * 可以根据用户hash过后的密文获得access_token
     * @param $password
     * @return bool
     */
    public function validateForPassportPasswordGrant($password)
    {
        return $password == $this->password || Hash::check($password, $this->password);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'mobile', 'name', 'nickname', 'password', 'parent_id', 'invitation_code', 'ip', 'last_login_ip', 'last_login_time', 'grandpa_id', 'operator_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',  'updated_at'
    ];

    /**
     * 推荐人
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function parentUser()
    {
        return $this->hasOne(User::class, 'id', 'parent_id');
    }

    /**
     * 关联的推荐人
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function childrenUser()
    {
        return $this->hasMany(User::class, 'parent_id', 'id');
    }

    /**
     * 获得粉丝信息
     * @param $id
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function fans($id)
    {
        return self::where([['parent_id', $id], ['status', '1']])->select(['id', 'mobile', 'nickname', 'avatar', 'created_at']);
    }

    /**
     * 获得孙子信息
     * @param $id
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function grandson($id)
    {
        return self::where([['grandpa_id', $id], ['parent_id', '<>', $id], ['status', '1']])->select(['id', 'mobile', 'nickname', 'avatar', 'created_at']);
    }

    public static function createNew($ip, $mobile, $password = null, $invitation_code = null)
    {
        if (is_null($invitation_code)) {//没有推荐码
            $grandpa_id = $operator_id = $parent_id = null;
        } else {
            $parent_id = decodeInvitationCode($invitation_code);
            $parent = self::find($parent_id);
            if ($parent->grade == '2') {//运营商
                $grandpa_id = $operator_id = $parent->id;
            } else {
                $grandpa_id = $parent->parent_id;
                $operator_id = $parent->operator_id;
            }
        }
        //事务开始
        DB::transaction(function () use ($ip, $mobile, $password, $parent_id, $grandpa_id, $operator_id, &$user) {
            $taobaoPidModel = TaobaoPid::where('userId')->lockForUpdate()->first();//查找出来一个PID
            $user = User::create([
                'parent_id' => $parent_id,
                'grandpa_id' => $grandpa_id,
                'operator_id' => $operator_id,
                'mobile' => $mobile,
                'password' => is_null($password) ? '1' : Hash::make($password),
                'ip' => $ip
            ]);
            $user->invitation_code = createInvitationCode($user->id);
            if ($taobaoPidModel) {//有淘宝PID
                $taobaoPidModel->userId = $user->id;
                $taobaoPidModel->save();
                $user->taobao_pid = $taobaoPidModel->pid;
            } else {//无淘宝PID

            }
            $user->save();
            Account::initAcount($user->id);
        }, 5);
        return $user;

    }
}
