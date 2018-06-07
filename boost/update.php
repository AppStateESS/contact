<?php

/**
 * @author Matthew McNaney <mcnaney at gmail dot com>
 */
function contact_update(&$content, $currentVersion)
{
    switch ($currentVersion) {

        case version_compare($currentVersion, '1.1.0', '<'):
            $content[] = <<<EOF
<pre>
1.1.0
-----------
+ Added front page only option.
+ Fixed Mozilla map bug.
</pre>
EOF;
        case version_compare($currentVersion, '1.2.0', '<'):
            $content[] = <<<EOF
<pre>
1.2.0
-----------
+ Updated Font Awesome icons
</pre>
EOF;

            return true;
    }
}
?>