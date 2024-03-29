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
1.5.0
-----------
+ Added alternate email link support.
</pre>
EOF;
        case version_compare($currentVersion, '1.5.1', '<'):
            $content[] = <<<EOF
<pre>
1.5.1
-----------
+ Fixed error with unused setting.
</pre>
EOF;
        case version_compare($currentVersion, '1.5.2', '<'):
            $content[] = <<<EOF
<pre>
1.5.2
-----------
+ Fixed error with typo.
</pre>
EOF;
        case version_compare($currentVersion, '1.5.3', '<'):
            $content[] = <<<EOF
<pre>
1.5.3
-----------
+ Fixed bug with clicking email icons.
</pre>
EOF;

        case version_compare($currentVersion, '1.5.4', '<'):
            $content[] = <<<EOF
<pre>
1.5.4
-----------
+ Added calendar icon.
+ Building no longer required.
+ Fixed social icon refresh menu.
+ Updated npm.
</pre>
EOF;

        case version_compare($currentVersion, '1.5.5', '<'):
            $content[] = <<<EOF
<pre>
1.5.5
-----------
+ Contact header does not show if there isn't any data.
+ Fixed #11: Map tab broken if no content has been entered.
</pre>
EOF;
        case version_compare($currentVersion, '1.5.6', '<'):
            $content[] = <<<EOF
<pre>
1.5.6
-----------
+ AppSync added
</pre>
EOF;
        case version_compare($currentVersion, '1.5.7', '<'):
            $content[] = <<<EOF
<pre>
1.5.7
-----------
+ Libraries updated
+ Updated default email parameter</pre>
EOF;
        case version_compare($currentVersion, '1.5.8', '<'):
            $content[] = <<<EOF
<pre>
1.5.8
-----------
+ NPM update</pre>
EOF;
        case version_compare($currentVersion, '1.5.9', '<'):
            $content[] = <<<EOF
<pre>
1.5.9
-----------
+ NPM update</pre>
EOF;
        case version_compare($currentVersion, '1.5.10', '<'):
            $content[] = <<<EOF
<pre>
1.5.10
-----------
+ NPM update</pre>
EOF;
        case version_compare($currentVersion, '1.6.0', '<'):
            $content[] = <<<EOF
<pre>
1.6.0
-----------
+ NPM update
+ Email fixes
+ Captcha update
</pre>
EOF;

            return true;
    }
}

?>
