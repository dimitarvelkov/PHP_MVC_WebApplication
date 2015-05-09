<form class="form-horizontal col-sm-8 col-sm-offset-2" action="/accounts/register" method="post" >
    <fieldset>
        <legend>Регистрация</legend>
        <div class="form-group">
            <label for="inputUsername" class="col-lg-3 control-label">Име</label>
            <div class="col-lg-9">
                <input type="text" name="username" class="form-control" id="inputUsername" placeholder="Име">
            </div>
        </div>
        <div class="form-group">
            <label for="inputPassword"  class="col-lg-3 control-label">Парола</label>
            <div class="col-lg-9">
                <input type="password" name="password" class="form-control" id="inputPassword" placeholder="Парола">
            </div>
        </div>
        <div class="form-group">
            <label for="inputConfirmPassword"  class="col-lg-3 control-label">Потвърждавне</label>
            <div class="col-lg-9">
                <input type="password" name="confirmPassword" class="form-control" id="inputConfirmPassword" placeholder="Потвърждавне на паролта">
            </div>
        </div>
        <div class="form-group">
            <label for="inputEmail"  class="col-lg-3 control-label">Имеил</label>
            <div class="col-lg-9">
                <input type="email" name="еmail" class="form-control" id="inputEmail" placeholder="Имеил">
            </div>
        </div>
        <div class="form-group">
            <div class="col-lg-9 col-lg-offset-3">
                <button type="submit"  class="btn btn-primary">Регистрираи</button>
                <a href="/accounts/login">Вход</a>
            </div>
        </div>
    </fieldset>
</form>
