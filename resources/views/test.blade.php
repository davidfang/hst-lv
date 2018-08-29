@extends('layouts.mobile')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Dashboard</div>

                    <div class="card-body">

                        You are logged in!
                        <button id="button">点我</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
<script>
    window.onload = function () {
        document.getElementById('button').onclick = function () {
            if (window.originalPostMessage) {
                let data = {
                    commond: 'Toast.show("aaaaa")',
                    payload: ['aaaaa']
                }
                window.postMessage(JSON.stringify(data));
            } else {
                console.log('postMessage接口还未注入')
                alert('postMessage接口还未注入')
                throw Error('postMessage接口还未注入');
            }
        }
    }
</script>