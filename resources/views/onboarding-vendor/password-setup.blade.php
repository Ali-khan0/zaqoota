<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="robots" content="noindex,nofollow">
    <title>{{ $completed ? 'Password created' : 'Set your Zaqoota password' }}</title>
    <style>
        *{box-sizing:border-box}body{margin:0;background:#f4f8f8;color:#17333a;font-family:Arial,sans-serif}.shell{width:min(520px,calc(100% - 32px));margin:40px auto}.brand{text-align:center;color:#0d988d;font-weight:800;font-size:28px;margin-bottom:20px}.card{background:#fff;border:1px solid #dbeae8;border-radius:20px;box-shadow:0 14px 40px rgba(22,66,63,.09);padding:30px}.muted{color:#718096;line-height:1.55}.field{width:100%;padding:13px 14px;border:1px solid #d8e5e4;border-radius:10px;margin-top:7px;font-size:15px}.field:focus{outline:2px solid rgba(13,152,141,.18);border-color:#0d988d}.label{display:block;margin-top:16px;font-weight:700}.button{display:block;width:100%;border:0;border-radius:11px;padding:14px;margin-top:22px;background:#0d988d;color:#fff;text-align:center;text-decoration:none;font-size:15px;font-weight:700;cursor:pointer}.alert{padding:13px 15px;border-radius:10px;background:#fde8e8;color:#9b1c1c;margin-bottom:16px}.success{width:64px;height:64px;margin:0 auto 18px;border-radius:50%;display:grid;place-items:center;background:#dff7ef;color:#08745b;font-size:30px;font-weight:800}@media(max-width:480px){.shell{margin:18px auto}.card{padding:22px;border-radius:16px}}
    </style>
</head>
<body>
<main class="shell">
    <div class="brand">ZAQOOTA</div>
    <section class="card">
        @if($completed)
            <div class="success">✓</div>
            <h1 style="text-align:center;margin:0 0 10px;font-size:24px">Password created</h1>
            <p class="muted" style="text-align:center">Your partner account is ready. Sign in with <strong>{{ $vendor->email }}</strong> and the password you just created.</p>
            <a class="button" href="{{ $loginUrl }}">Open partner login</a>
        @else
            <h1 style="margin:0 0 8px;font-size:24px">Create your password</h1>
            <p class="muted">{{ $setup->application->store_name }} is approved. Choose a strong password for the partner account <strong>{{ $setup->vendor->email }}</strong>.</p>
            @if($errors->any())<div class="alert">{{ $errors->first() }}</div>@endif
            <form method="post" action="{{ request()->fullUrl() }}">
                @csrf
                <label class="label" for="password">Password</label>
                <input class="field" id="password" name="password" type="password" autocomplete="new-password" required>
                <label class="label" for="password_confirmation">Confirm password</label>
                <input class="field" id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required>
                <p class="muted" style="font-size:13px">Use at least 8 characters with uppercase, lowercase, number and symbol. Spaces are not allowed.</p>
                <button class="button" type="submit">Create password</button>
            </form>
        @endif
    </section>
</main>
</body>
</html>
