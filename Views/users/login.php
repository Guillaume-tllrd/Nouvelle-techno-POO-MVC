<form action="#" method="post">
    <label for="email">E-mail:</label>
    <input type="email" name="email" id='email' class="form-control">
    <!-- la classe form-control est pour Bootsrap -->
    <label for="password">E-mail:</label>
    <input type="password" name="password" id='password' class="form-control" autofocus>
    <!-- ['id' => 'password' , 'class' => 'form-control', 'autofocus' => true]-->
    <!-- ex de tableau envoyé dans notre méthode création d'attributs (ajoutAttributs) -->
    <button class="btn btn-primary">Me connecter</button>
</form>