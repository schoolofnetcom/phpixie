<?php

$this->layout('app:layout');
$this->set('pageTitle', 'Autenticação');

?>

<form action="<?php echo $this->httpPath('app.processor', ['processor' => 'auth']); ?>" method="post">
  <h2>Login</h2>

    <?php
        $error = $this->if($loginForm->fieldValue('email'), 'style="color:red;"');
        $emailValue = $loginForm->fieldValue('email');
    ?>
    Email: <input type="email" name="email" <?php echo $error;?> value="<?php echo $emailValue;?>"><br>
    <?php if($error = $loginForm->fieldError('email')): ?>
        <div><?php echo $error?></div>
    <?php endif;?>

    Senha: <input type="password" name="password"<?php $this->if($loginForm->fieldValue('password'), 'style="color:red;"')?>><br>
    <?php if($error = $loginForm->fieldError('password')): ?>
        <div><?php echo $error?></div>
    <?php endif;?>

    <?php if($error = $loginForm->resultError()): ?>
        <div class="form-group has-danger">
            <div><?php echo $error?></div>
        </div>
    <?php endif;?>

    <input type="submit" value="Enviar">
</form>

<form method="POST" action="<?=$this->httpPath('app.processor', ['processor' => 'auth'])?>">
  <h2>Registro</h2>

    <?php if($error = $registerForm->resultError()): ?>
      <div><?=$error?></div>
    <?php endif;?>

  Nome: <input name="name" type="text" value="<?=$_($registerForm->fieldValue('name'))?>"><br>
    <?php if($error = $registerForm->fieldError('name')): ?>
      <div><?=$error?></div>
    <?php endif;?>

  Email: <input name="email" type="text" value="<?=$_($registerForm->fieldValue('email'))?>"><br>
    <?php if($error = $registerForm->fieldError('email')): ?>
      <div><?=$error?></div>
    <?php endif;?>

  Senha: <input name="password" type="password"><br>
    <?php if($error = $registerForm->fieldError('password')): ?>
      <div><?=$error?></div>
    <?php endif;?>

  Confirmação de senha: <input name="passwordConfirm" type="password">
    <?php if($error = $registerForm->fieldError('passwordConfirm')): ?><br>
      <div><?=$error?></div>
    <?php endif;?>

  <input type="hidden" name="register" value="1">
  <input type="submit" value="Enviar">
</form>
