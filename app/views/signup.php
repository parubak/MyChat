<?=$header??""?>
<main class="form-signin-h">
    <form action="/signup" method="post">
        <img class="mb-4" src="https://getbootstrap.com/docs/5.1/assets/brand/bootstrap-logo.svg" alt="" width="72" height="57">
        <h1 class="h3 mb-3 fw-normal">Please sign up</h1>

        <div class="form-floating">
            <input name="email" type="email" class="form-control" id="floatingInput" placeholder="name@example.com">
            <label for="floatingInput">Email address</label>
        </div>
        <div class="form-floating">
            <input name="password" type="password" class="form-control" id="floatingPassword" placeholder="Password">
            <label for="floatingPassword">Password</label>
        </div>
        <div class="form-floating">
            <input name="repeat_password" type="password" class="form-control" id="floatingPassword" placeholder="Repeat password">
            <label for="floatingPassword">Repeat password</label>
        </div>
        <div class="error"><?=$error??""?></div>
        <button class="w-100 btn btn-lg btn-primary" type="submit">Sign up</button>
    </form>
</main>
