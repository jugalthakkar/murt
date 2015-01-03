<?php

        require_once("SnapshotService.php");
        SnapshotService::RecreateSnapshots();
        echo "Updated: " .  date('l jS \of F Y h:i:s A');
        require_once("teardown.php");