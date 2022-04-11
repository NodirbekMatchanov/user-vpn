<?php
echo "start";
exec('php yii server/update-active-user > run.log');
echo "end";
