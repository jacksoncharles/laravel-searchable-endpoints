vendor/autoload.php

<?php

exec('vendor/bin/phinx migrate -c tests/phinx.yml');
exec('vendor/bin/phinx seed:run -c tests/phinx.yml');