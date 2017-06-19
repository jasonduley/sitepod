<?php
/* This file is part of Sitepod.
 *
 * Sitepod is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Sitepod is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Sitepod.  If not, see <http://www.gnu.org/licenses/>.
 */

require_once(dirname(__FILE__) . '/inc/startup.php');

// check settings
if ($SETTINGS['website'] == "") {
    // no settings yet, force user to setup this first
    $LAYOUT->addError('Please edit the settings <a href="index.php">here</a> and store them to the file system!', 'No valid settings found!');
} else { // settings exists, lets start = (German:) los gehts. :)
    $FILE = parseFilesystem();


    if (count($FILE) > 0) {
        if (!writeSitemap($FILE)) {
            $LAYOUT->addError('', 'Could not create sitemap file, giving up!');
        } else {
            $LAYOUT->addSuccess('Sitemap has been created and written to filesystem!', 'Sitemap successful created');
            if ($SETTINGS[PSNG_PINGGOOGLE]) {
                submitPageToGoogle();
                $LAYOUT->addSuccess('Sitemap has been submitted to Google!', 'Finished my job');
            } else {
                $LAYOUT->addInfo('Value for submit to google not set in settings', 'Sitemap not submitted to Google');
            }
        }
    } else {
        $LAYOUT->addError('Will not write sitemap to filesystem nor submit it to Google!', 'Result from plugins was empty!');
    }
}

require_once('inc/shutdown.php');

?>
