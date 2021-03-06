<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>YouTube Upload Script</title>
        <style type="text/css">
            label,
            input {
                display: block;
                margin: 0 0 5px 0;
            }
        </style>
    </head>
    <body>

        <?php
        //If the 1st step form has been submited, run the token script.
        if( isset( $_POST['video_title'] ) && isset( $_POST['video_description'] ) ) {
            $video_title = stripslashes( $_POST['video_title'] );
            $video_description = stripslashes( $_POST['video_description'] );
            include_once( 'get_youtube_token.php' );
        }

        // Specifies the url that youtube will return to. The data it returns are as get variables
        $nexturl = "http://example.com/uploader";
        // These are the get variables youtube returns once the video has been uploaded.
        $unique_id = $_GET['id'];
        $status = $_GET['status'];
        ?>

        <!-- Step 1 of the youtube upload process -->
        <?php if( empty( $_POST['video_title'] ) && $unique_id == "" ) : ?>
            <form action="" method="post">
                <label for="video_title">Video Title</label>
                <input type="text" name="video_title" />
                <label for="video_description">Video Description</label>
                <textarea id="video-description" name="video_description"></textarea>
            </form>

            <form action="<?php echo( $response->url ); ?>?nexturl=<?php echo( urlencode( $nexturl ) ); ?>" method="post" enctype="multipart/form-data">
                <p class="block">
                    <label>Upload Video</label>
                    <span class="youtube-input">
                        <input id="file" type="file" name="file" />
                    </span>
                </p>
                <input type="hidden" name="token" value="<?php echo( $response->token ); ?>"/>
                <input type="submit" value="Upload Video" />
            </form> <!-- /form -->

        <!-- Final Step -->
        <?php elseif( $unique_id != '' && $status = '200' ) : ?>
        <div id="video-success">
            <h4>Video Successfully Uploaded!</h4>

            <p>Here is your url to view your video:<a href="http://www.youtube.com/watch?v=<?php echo $unique_id; ?>" target="_blank">http://www.youtube.com/watch?v=<?php echo $unique_id; ?></a></p>
        </div> <!-- /div#video-success -->
        <?php endif; ?>

    </body>
</html>
