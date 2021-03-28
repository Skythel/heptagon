    </div> <!-- End wrapper -->
    <div class="footer">v<?php echo $app_ver; ?> ¤ Created by Heptagon | <a href="https://github.com/Skythel/heptagon" target="_blank">source code</a></div>
    <script src="misc.js?v=<?php echo $scripts_ver; ?>"></script>
<?php if(isset($cfg_title) && $cfg_title == "Login - MemoryMaze") { ?>
    <script src="login.js?v=<?php echo $scripts_ver; ?>"></script>
<?php } ?>
</body>
</html>
