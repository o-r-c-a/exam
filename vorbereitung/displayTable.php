<main>
        <div class="container jumbotron">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Filename</th>
                        <th scope="col">Filesize (KB)</th>
                        <th scope="col">Upload Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $dir = 'uploads/';
                        $files = scandir($dir);
                        $files = array_diff($files, array('.', '..'));
                        $fileInfo = [];

                        foreach($files as $file){
                            $fileInfo[$file] = filemtime($dir . $file);
                        }
                        arsort($fileInfo);

                        foreach($fileInfo as $file => $modifiedTime){
                                $fileSize = filesize($dir . $file) / 1024;
                                $uploadDate = date('d.m.Y H:i', $modifiedTime);
                                echo '<tr>';
                                echo '<td><a href="' . $dir . $file . '">' . $file . '</a></td>';
                                echo '<td>' . round($fileSize) . '</td>';
                                echo '<td>' . $uploadDate . '</td>';
                                echo '</tr>';
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </main>