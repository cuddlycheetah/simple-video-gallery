<?php
    if(isset($_GET["series"])) {
        $files = glob('*/*.{mp4}', GLOB_BRACE);
        $series = array();

        foreach ($files as $file) {
            $dir = dirname($file);
            if (!isset($series[$dir])) $series[$dir] = array();

            $info = json_decode(file_get_contents("$dir/info.json"));

            if (!isset($series[$dir]['dir'])) $series[$dir]['dir'] = $dir;
            if (!isset($series[$dir]['info'])) $series[$dir]['info'] = $info;
            if (!isset($series[$dir]['episodes'])) $series[$dir]['episodes'] = array();

            $episodeName = basename($file, '.mp4');
            
            $seasonStr = explode('_', $episodeName)[1];
            $seasonStr = substr($seasonStr, 1);
            
            $episodeStr = explode('_', $episodeName)[2];
            $episodeStr = substr($episodeStr, 1);

            $episode = array();

            $episode["file"] = $file;
            $episode["index"] = intval($episodeStr);
            $episode["thumb"] = $dir . '/' . $episodeName . '.png';
            $episode["info"] = $dir . '/' . $episodeName . '.info.html';
            $episode["season"] = intval($seasonStr);

            array_push($series[$dir]['episodes'], $episode);
        }
        echo json_encode($series);
        exit;
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <base href="/mirror/">
        <meta charset="utf-8">
        <title>schumann.mirror</title>
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.7.5/angular.min.js"></script>
        <link rel="stylesheet" href="index.css?<?php echo time(); ?>">
    </head>
    <body ng-app="mirrorviewer" ng-controller="SeriesCtrl">
        <h1 class="removeByScript">
            Bitte aktiviere dein Javascript auf dieser Website!
        </h1>
        <div id="main">
            <div class="player" ng-show="!!selectedVideo">
                <a name="video-player">
                <video height="360" src="{{ selectedVideo.file }}" poster="{{ selectedVideo.thumb }}" controls></video>
            </div>
            <div class="list" ng-init="i=0">
                <div class="series" ng-repeat="(sIndex,serie) in series">
                    <h3>{{ serie.info.name }} | <a href="{{ sIndex }}/">Raw</a></h3>
                    <div class="episodeList">
                        <div class="episode float" ng-repeat="(episodeIndex, episode) in serie.episodes"
                            data-selected="{{ selectedIndex == sIndex + '_' + episodeIndex }}"
                            ng-click="playEpisode(episode, sIndex + '_' + episodeIndex)">
                            <table cellspacing="0">
                                <tr>
                                    <td><img style="height:144px;" src="{{ episode.thumb }}"/></td>
                                    <td><pre>
Staffel: {{ episode.season }} Episode: {{ episode.index }}
<a href="{{ episode.info }}">Info</a>
                                    </pre></td>
                                </tr>
                            </table>
                        </div>
                        <div class="clear">
                    </div>
                </div>
            </div>
        </div>
    </body>
    <script type="text/javascript" src="index.js?<?php echo time(); ?>"></script>
</html>