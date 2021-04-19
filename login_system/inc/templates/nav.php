<div>
    <div class="float-left">
        <P>
            <a href="index.php?task=report">All Students</a> |
            <?php if(isAdmin() || isManager()): ?>
                <a href="index.php?task=add">Add New Students</a> 
            <?php endif; ?>
            <?php 
                if(isAdmin()):
            ?>
                |
                <a href="index.php?task=seed">Seed</a>
            <?php endif; ?>
        </p>
    </div> <!-- end .float-left -->
    <div class="float-right">
        <?php 
            if(!$_SESSION['loggedin']):
        ?>
        <a href="auth.php">Login</a>
        <?php else: ?>
        <a href="auth.php?logout=true">Logout (<?php echo $_SESSION['role'] ?>)</a>
        <?php endif; ?>
    </div> <!-- end .float-right -->
</div>