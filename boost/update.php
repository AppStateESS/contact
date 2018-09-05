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
        case version_compare($currentVersion, '1.2.1', '<'):
            $content[] = <<<EOF
<pre>
1.2.1
-----------
+ Updated Bootstrap layout
+ Disabled Google map interface.
</pre>
EOF;
        case version_compare($currentVersion, '1.2.2', '<'):
            $content[] = <<<EOF
<pre>
1.2.2
-----------
+ Removed layout classes.
</pre>
EOF;
        case version_compare($currentVersion, '1.2.3', '<'):
            $content[] = <<<EOF
<pre>
1.2.3
-----------
+ Horizontal rule only appears if other information is present.
</pre>
EOF;

        case version_compare($currentVersion, '1.3.0', '<'):
            $content[] = <<<EOF
<pre>
1.3.0
-----------
+ Rewritten in React to use new maps.
</pre>
EOF;
        case version_compare($currentVersion, '1.3.1', '<'):
            $content[] = <<<EOF
<pre>
1.3.1
-----------
+ Removed unused code.
</pre>
EOF;
        case version_compare($currentVersion, '1.3.2', '<'):
            $content[] = <<<EOF
<pre>
1.3.2
-----------
+ Fixed email address printing.
</pre>
EOF;
        case version_compare($currentVersion, '1.4.0', '<'):
            $content[] = <<<EOF
<pre>
1.4.0
-----------
+ Bug fixes with display
+ Can set thumbnail by lat/long.
</pre>
EOF;

        case version_compare($currentVersion, '1.5.0', '<'):
            $content[] = <<<EOF
<pre>
1.4.0
-----------
+ Bug fixes with display
+ Can set thumbnail by lat/long.
</pre>
EOF;

            return true;
    }
}

?>
