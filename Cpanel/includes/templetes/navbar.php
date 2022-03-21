<nav class="navbar navbar-inverse">
  <div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-nav" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="dashboard.php"> <?php echo lang("Home_Admin") ?> </a>
    </div>

    <div class="collapse navbar-collapse" id="app-nav">
      <ul class="nav navbar-nav">
        <li><a href="categories.php"> <?php echo lang("CATEGORIES") ?> </a></li>
        <li><a href="items.php"> <?php echo lang("services") ?> </a></li>
        <li><a href="members.php?offset=0"> <?php echo lang("MEMBERS") ?> </a></li>
        <li><a href="comments.php"> <?php echo lang("COMMENTS") ?> </a></li>
        <!-- <li><a href="transactions.php"> <?php //echo lang("transactions") ?> </a></li> -->
        <!--<li><a href="#"> -->
          <?php // echo lang("STATISTICS") ?>
           <!--</a></li>-->
        <!--<li><a href="#">-->
           <?php // echo lang("LOGS")  ?>
            <!--</a></li>-->
          </ul>
        </li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $_SESSION['Username']?> <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="../index.php">عرض الموقع</a>
            <li><a href="members.php?do=Edit&userid=<?php echo $_SESSION['ID']?>"><?php echo lang('PROFILE')?></a></li>
            <li><a href="settings.php"><?php echo lang('SETTINGS')?></a></li>
            <li><a href="logout.php"><?php echo lang('OUT')?></a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>