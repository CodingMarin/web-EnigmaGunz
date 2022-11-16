     <?php
        if(!$_SESSION['userid'])
        { 
		    ?>
		<font color="#3488a8">Bienvenido, Invitado!</font>
                <form action="" method="post">
                    <input type="text" name="user" class="inputbg" value="Username" onfocus="this.value=''"><br>
                    <input type="password" name="pass" class="inputbg" value="Password" onfocus="this.value=''"><br>
                    <br><input type="submit" name="login" value="" class="submitbg" /><a href="?page=register"><div class="register"></div></a>
                </form>
        <?php
		}
        else
        {
          if($_GET['page'] == "admin")
          {
        ?>

                    <font color="#3488a8">Funciones del Administrador:<br /><br />
                    <a href="?page=admin">-) Admin - Inicio</a><br />
                    <a href="?page=admin&function=updates">-) Agregar &amp; Editar Updates</a><br />
                    <a href="?page=admin&function=ipban">-) Banear IP</a><br />
		    <a href="?page=admin&function=anounce">-) Agregar un Anuncio</a><br />
                    <a href="?page=admin&function=addcoins">-) Agregar Donator Coins a un Usuario</a><br />
		    <a href="?page=admin&function=addecoins">-) Agregar Event Coins a un Usuario</a><br />
		    <a href="?page=admin&function=addpcoins">-) Agregar Premiun Coins a un Usuario</a><br /></font>

        <?php
          }
          else
          {
        ?>
            
                    <font color="#3488a8">Bienvenido, <?php echo $_SESSION['userid']; ?>!</font><br /><br />
                    <a href="?page=account">-) Mi Cuenta</a><br />
                    <a href="?page=character">-) Mis Personajes</a><br />
                    <a href="?page=clan">-) Mi Clan</a><br />
                    <a href="?page=donate">-) Donate</a><br />
		    <a href="/Name Color/index.php?do=buycolorname">-) Comprar Nombre a Color</a><br />
                    <a href="?action=logout">-) Desconectarse</a><br /><br />

        <?php
          }
        }
        ?>
