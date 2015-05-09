<form class="form-horizontal col-sm-6 col-sm-offset-3" action="/accounts/login" method="post" >
    <fieldset>
        <legend>Вход</legend>
        <div class="form-group">
            <label for="inputUsername" class="col-lg-2 control-label">Име</label>
            <div class="col-lg-10">
                <input type="text" name="username" class="form-control" id="inputUsername" placeholder="Име">
            </div>
        </div>
        <div class="form-group">
            <label for="inputPassword"  class="col-lg-2 control-label">Парола</label>
            <div class="col-lg-10">
                <input type="password" name="password" class="form-control" id="inputPassword" placeholder="Парола">
            </div>
        </div>
        <div class="form-group">
            <div class="col-lg-10 col-lg-offset-2">
                <button type="submit"  class="btn btn-primary">Вход</button>

                <a href="/accounts/register">Регистрация</a>
            </div>
        </div>
    </fieldset>
</form>
