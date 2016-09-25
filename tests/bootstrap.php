vendor/autoload.php

<?php
exec('rm tests/database.sqlite > /dev/null');
exec('touch tests/database.sqlite > /dev/null');
exec('vendor/bin/phinx migrate -c tests/phinx.yml > /dev/null');
exec('vendor/bin/phinx seed:run -c tests/phinx.yml > /dev/null');