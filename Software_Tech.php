<?php

/*
Plugin Name: updateNotice
Plugin URI: https://nxtg-t.net/
Description: 投稿記事、固定ページの更新を取得して通知するプラグイン
Author: Sorarinu
Version: 1.0
Author URI: https://nxtg-t.net/
*/
?>

<?php

add_action('admin_menu','soft_admin_menu');
add_action('publish_post','sendMail');
add_action('publish_page','sendMail');

function soft_admin_menu(){
	add_menu_page(
		'素敵なプラグイン - 設定',
		'素敵なプラグイン',
		'administrator',
		'soft_admin_menu',
		'soft_edit_setting',
		'',
		3
	);
}

function soft_edit_setting(){
	//管理画面作成
	add_option('MaxNum');
	add_option('Sort');
	add_option('SendMailFrom');
	add_option('SendMailSub');
	add_option('SendMailText');
	add_option('SendMailTextAdd');
	add_option('WPROOTDIR');
	add_option('WPROOTDIR2');

	if ($_REQUEST['MaxNum']) update_option('MaxNum', $_REQUEST['MaxNum']);
	if ($_REQUEST['Sort']) update_option('Sort', $_REQUEST['Sort']);
	if ($_REQUEST['SendMailFrom']) update_option('SendMailFrom', $_REQUEST['SendMailFrom']);
	if ($_REQUEST['SendMailSub']) update_option('SendMailSub', $_REQUEST['SendMailSub']);
	if ($_REQUEST['SendMailText']) update_option('SendMailText', $_REQUEST['SendMailText']);
	if ($_REQUEST['SendMailTextAdd']) update_option('SendMailTextAdd', $_REQUEST['SendMailTextAdd']);
	if ($_REQUEST['WPROOTDIR']) update_option('WPROOTDIR', $_REQUEST['WPROOTDIR']);
	if ($_REQUEST['WPROOTDIR2']) update_option('WPROOTDIR2', $_REQUEST['WPROOTDIR2']);

	$MaxNum=get_option('MaxNum');
	$Sort=get_option('Sort');
        $SendMailFrom=get_option('SendMailFrom');
        $SendMailSub=get_option('SendMailSub');
        $SendMailText=get_option('SendMailText');
	$SendMailTextAdd=get_option('SendMailTextAdd');
	$WPROOTDIR=get_option('WPROOTDIR');
	$WPROOTDIR2=get_option('WPROOTDIR2');

echo <<<EOD
	<div id="icon-options-general" class="icon32"></div>

	<h2>Software_Tech_Kadai3 - 設定メニュー</h2>
	<br><br>
	<form method="post" action="">
		<table class="form-table">
			<tr valign="top">
        			<th scope="row"><label for="MaxNum">表示最大数</label></th>
        			<td><select name="MaxNum" id="MaxNum">
					<option value="1">1</option>
                               		<option value="2">2</option>
                               		<option value="3">3</option>
                               		<option value="4">4</option>
                               		<option value="5" selected>5</option>
				</select></td>
    			</tr>
			<tr valign="top">
                                <th scope="row"><label for="Sort">表示順</label></th>
                                <td><select name="Sort" id="Sort">
                                        <option value="ASC">昇順</option>
                                        <option value="DESC" selected>降順</option>
                                </select></td>
                        </tr>
			<tr valign="top">
			        <th scope="row"><label for="SendMailFrom">通知メール送信者アドレス</label></th>
			        <td><input name="SendMailFrom" type="text" value="{$SendMailFrom}" class="regular-text">
       				<p class="description">通知メールを送信する為の送信者アドレスを入力</p></td>
    			</tr>
			<tr valign="top">
                                <th scope="row"><label for="SendMailSub">通知メールの件名</label></th>
                                <td><input name="SendMailSub" type="text" value="{$SendMailSub}" class="regular-text">
                                <p class="description">通知メールで表示する件名を入力</p></td>
                        </tr>
			<tr valign="top">
                                <th scope="row"><label for="SendMailText">通知メールの内容(新規投稿時)</label></th>
                                <td><textarea name="SendMailText" cols="52" rows="10">{$SendMailText}</textarea>
                                <p class="description">新規投稿時に送信する通知メールで表示する本文を入力</p></td>
                        </tr>
			<tr valign="top">
                                <th scope="row"><label for="SendMailTextAdd">通知メールの内容(記事更新時)</label></th>
                                <td><textarea name="SendMailTextAdd" cols="52" rows="10">{$SendMailTextAdd}</textarea>
                                <p class="description">記事更新時に送信する通知メールで表示する本文を入力</p></td>
                        </tr>
			<br><br>
			<tr valign="top">
                                <th scope="row"><label for="WPROOTDIR">ブログのURL</label></th>
                                <td><input name="WPROOTDIR" type="text" value="{$WPROOTDIR}" class="regular-text">
                                <p class="description">ブログのURLを入力<br>(例)http://hogehoge.co.jp/</p></td>
                        </tr>
			<tr valign="top">
                                <th scope="row"><label for="WPROOTDIR2">WordPressインストールディレクトリ</label></th>
                                <td><input name="WPROOTDIR2" type="text" value="{$WPROOTDIR2}" class="regular-text">
                                <p class="description">WordPressのインストールディレクトリをフルパスで指定<br>(例)/var/www/wordpress/</p></td>
                        </tr>
		</table>

		<p class="submit">
        		<input type="submit" name="submit" id="submit" class="button-primary" value="変更を保存">
    		</p>
	</form>
EOD;
	echo "<br><br><br>********************************************デバッグ用********************************************<br><br>";
	if($Sort==ASC){
		$SortStr="昇順";
	}elseif($Sort==DESC){
		$SortStr="降順";
	}

echo <<<EOF
	<table border="3">
	<tr>
	<th>項目</th>
	<th>データベースに保持されている変数の内容</th>
	</tr>
	<tr>
	<td>最大表示数</td>
	<td>$MaxNum</td>
	</tr>
	<tr>
	<td>ソート順</td>
	<td>$SortStr</td>
	</tr>
	<tr>
	<td>送信者アドレス</td>
	<td>$SendMailFrom</td>
	</tr>
	<tr>
	<td>件名</td>
	<td>$SendMailSub</td>
	</tr>
	<tr>
	<td>内容新規</td>
	<td>$SendMailText</td>
	</tr>
	<tr>
	<td>内容追加</td>
	<td>$SendMailTextAdd</td>
	</tr>
	<tr>
	<td>ブログURL</td>
	<td>$WPROOTDIR</td>
	</tr>
	<tr>
	<td>WPディレクトリ</td>
	<td>$WPROOTDIR2</td>
	</tr>
	</table>
EOF;
	
	global $wpdb;
	
	echo "<br><br><br>";
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

	echo "***************自ブログ更新確認***************<br><br>";

        foreach ($results as $value) {
                echo '<dt>公開日 : ' . date('Y年m月d日', strtotime($value->post_date)) . '</dt>';
                echo '<dd><a href="'.get_permalink($value->ID).'">'.$value->post_title.'</a>';
                echo "　　　最終更新日：";
                echo '<b>'. date('Y年m月d日', strtotime($value->post_modified)) . '</b></dd><br>';
        }

	echo "<br><br><br>";

	echo "***************固定ページ***************<br><br>";

	foreach ($results2 as $value) {
		echo '<dt>公開日 : ' . date('Y年m月d日', strtotime($value->post_date)) . '</dt>';
	        echo '<dd><a href="'.get_permalink($value->ID).'">'.$value->post_title.'</a>';
	        echo "　　　最終更新日：";
	        echo '<b>'. date('Y年m月d日', strtotime($value->post_modified)) . '</b></dd><br>';
	}

}

//メール通知
function sendMail(){
	global $wpdb;

	mb_language("Ja");
	mb_internal_encoding("UTF-8");

    $SendMailFrom=get_option('SendMailFrom');	//送信者
    $SendMailSub=get_option('SendMailSub');		//件名
    $SendMailText=get_option('SendMailText');	//本文
	$SendMailTextAdd=get_option('SendMailTextAdd');
	$WPROOTDIR=get_option('WPROOTDIR');

	$Address = $wpdb->get_results("
		SELECT user_email
		FROM $wpdb->users
	");

	//メール設定
	foreach($Address as $value){
		$MailTo[]=$value->user_email;		//宛先
	}

	//メール送信
	if($_POST['original_post_status'] != 'publish'){
		for($i=0;$i<count($MailTo);$i++){
			sleep(1);
			mb_send_mail("$MailTo[$i]", "{$SendMailSub}", "{$SendMailText}\n\n-----------------------------------\n\n更新の確認はこちら\n↓↓↓\n{$WPROOTDIR}Notice.php", "From: {$SendMailFrom}");
		}
	}else{
		for($i=0;$i<count($MailTo);$i++){
                        sleep(1);
                        mb_send_mail("$MailTo[$i]", "{$SendMailSub}", "{$SendMailTextAdd}\n\n-----------------------------------\n\n記事の確認はこちら\n↓↓↓\n{$WPROOTDIR}Notice.php", "From: {$SendMailFrom}");
                }
	}
}

?>

