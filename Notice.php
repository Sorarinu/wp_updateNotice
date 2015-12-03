<?php
        echo '<html>';
        echo '<title>更新通知</title>';
        echo '<body>';
		include("{$WPROOTDIR2}wp-config.php");

        add_option('MaxNum');
        add_option('Sort');
        add_option('SendMailFrom');
        add_option('SendMailSub');
        add_option('SendMailText');
        add_option('WPROOTDIR');
        add_option('WPROOTDIR2');

        if ($_REQUEST['MaxNum']) update_option('MaxNum', $_REQUEST['MaxNum']);
        if ($_REQUEST['Sort']) update_option('Sort', $_REQUEST['Sort']);
        if ($_REQUEST['SendMailFrom']) update_option('SendMailFrom', $_REQUEST['SendMailFrom']);
        if ($_REQUEST['SendMailSub']) update_option('SendMailSub', $_REQUEST['SendMailSub']);
        if ($_REQUEST['SendMailText']) update_option('SendMailText', $_REQUEST['SendMailText']);
        if ($_REQUEST['WPROOTDIR']) update_option('WPROOTDIR', $_REQUEST['WPROOTDIR']);
        if ($_REQUEST['WPROOTDIR2']) update_option('WPROOTDIR2', $_REQUEST['WPROOTDIR2']);

        $MaxNum=get_option('MaxNum');
        $Sort=get_option('Sort');
        $SendMailFrom=get_option('SendMailFrom');
        $SendMailSub=get_option('SendMailSub');
        $SendMailText=get_option('SendMailText');
        $WPROOTDIR=get_option('WPROOTDIR');
        $WPROOTDIR2=get_option('WPROOTDIR2');

        global $wpdb;
        $results = $wpdb->get_results("
                SELECT post_title, post_date, post_modified, guid, ID
                FROM $wpdb->posts
                WHERE post_type='post'
                AND post_status='publish'
                ORDER BY post_date $Sort
                LIMIT $MaxNum
        ");

        $results2 = $wpdb->get_results("
                SELECT post_title, post_date, post_modified, guid, ID
                FROM $wpdb->posts
                WHERE post_type='page'
                AND post_status='publish'
                ORDER BY post_date $Sort
                LIMIT $MaxNum
        ");

        echo "<br><font size=15><a href=$WPROOTDIR>ブログを確認する</a></font><br><br><br><br><br><br>";

        echo "<b>***************投稿ページ***************<b><br><br>";

        foreach ($results as $value) {
                echo '<dt>公開日 : ' . date('Y年m月d日', strtotime($value->post_date)) . '</dt>';
                echo '<dd><a href="'.get_permalink($value->ID).'">'.$value->post_title.'</a>';
                echo "　　　最終更新日：";
                echo '<b>'. date('Y年m月d日', strtotime($value->post_modified)) . '</b></dd><br>';
        }

        echo "<br><br><br>";

        echo "<b>***************固定ページ***************<b><br><br>";

        foreach ($results2 as $value) {
                echo '<dt>公開日 : ' . date('Y年m月d日', strtotime($value->post_date)) . '</dt>';
                echo '<dd><a href="'.get_permalink($value->ID).'">'.$value->post_title.'</a>';
                echo "　　　最終更新日：";
                echo '<b>'. date('Y年m月d日', strtotime($value->post_modified)) . '</b></dd><br>';
        }

        echo '</body>';
        echo '</html>';
?>
