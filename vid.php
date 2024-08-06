<?php
// Получаем список видеофайлов из папки /videos
$videoDir = 'videos';
$videos = array_diff(scandir($videoDir), array('..', '.'));

// Используем натуральную сортировку
natsort($videos);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Video Playlist</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        #videoPlayer {
            border: 1px solid #dee2e6;
            border-radius: 0.5rem;
        }
        #videoTitle {
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 20px;
        }
        #playlist .list-group-item {
            cursor: pointer;
        }
        #playlist .list-group-item:hover {
            background-color: #b7261254;
        }
        .playlist-container {
            max-height: 500px;
            overflow-y: auto;
            border: 1px solid #dee2e6;
            border-radius: 0.5rem;
            padding: 10px;
            background-color: #ffffff;
        }
        .main-container {
            margin-top: 40px;
        }
    </style>
</head>
<body>

<div class="container main-container">
    <h1 class="text-center">Против всех 2 сезон</h1>
    <h1 class="mb-4 text-center" id="videoTitle">Video Playlist</h1>
    <div class="row">
        <div class="col-md-8">
            <div class="ratio ratio-16x9">
                <video id="videoPlayer" class="w-100" controls>
                    
                    <source id="videoSource" src="" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>
        </div>
        <div class="col-md-4">
            <div class="playlist-container">
                <ul class="list-group" id="playlist">
                    <?php foreach ($videos as $video): ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center" data-src="<?php echo $videoDir . '/' . $video; ?>">
                            <?php echo $video; ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        function setVideoTitle(videoName) {
            var match = videoName.match(/(\d+\sсерия)/i);
            if (match) {
                var title = match[1];
                $('#videoTitle').html(title);
            } else {
                $('#videoTitle').text('Video Playlist');
            }
        }

        $('#playlist li').on('click', function () {
            var videoSrc = $(this).data('src');
            var videoName = $(this).text();
            $('#videoSource').attr('src', videoSrc);
            setVideoTitle(videoName);
            $('#videoPlayer')[0].load();
            $('#videoPlayer')[0].play();
        });

        // Автовоспроизведение первого видео в списке
        var firstVideo = $('#playlist li').first().data('src');
        var firstVideoName = $('#playlist li').first().text();
        if (firstVideo) {
            $('#videoSource').attr('src', firstVideo);
            setVideoTitle(firstVideoName);
            $('#videoPlayer')[0].load();
            $('#videoPlayer')[0].play();
        }
    });
</script>

</body>
</html>
