<?php
if (!empty($_SESSION['error'])): ?>
    <div class="alert alert-danger" role="alert"><?php echo $_SESSION['error'];
                                                    unset($_SESSION['error']); ?>
    </div>
    <!-- une fois que le le message a été modifié je le supprime avec unset -->
<?php endif; ?>
<h1>Connexion</h1>
<?= $loginForm ?>