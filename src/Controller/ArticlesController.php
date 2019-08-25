<?php
namespace App\Controller;

class ArticlesController extends AppController
{
	public function index()
	{
		$this->loadComponent('Paginator');
		$articles = $this->Paginator->paginate($this->Articles->find());
		$this->set(compact('articles'));
	}

	public function zip()
	{

		// Zipファイルの保存先
		$file = WWW_ROOT . 'attachment';
		$fileName = 'myfile' . time() . '.zip';
		/*
		 * zipコマンド
		 *
		 * 1. ディレクトリ移動
		 * 2. ファイル圧縮
		 */
		$dir = WWW_ROOT . 'attachment' .DS. '0001';
		$command =  'cd ' . $dir . ';' . // exampleディレクトリへ移動
			'zip -r '. $fileName . ' ./kyoei0001/'; // targetディレクトリを圧縮しmyfile.zipを作成
		exec($command);  // コマンド実行
		// zipファイルパス
		//var_dump($command);
		$zipPath = $dir.'/'.$fileName;
		//exec('cd' . $dir . ';' . 'zip -r' . $fileName . './kyoei0001/');
		// zip出力

		$url = $this->referer(array('action'=>'index'));
		//$this->redirect($url);
		/*header('Pragma: public');
		header("Content-Type: application/octet-stream");
		header("Content-Disposition: attachment; filename=".$fileName);*/
		//readfile($dir.'/'.$fileName);

		header( "Content-Type: application/zip" );
		header( "Content-Disposition: attachment; filename=" . basename( $zipPath ) );
		header( "Content-Length: " . filesize( $zipPath ) );
		ob_clean();
		flush();
		readfile( $zipPath );
		// Zipファイル削除
		//unlink( $zipPath );
		exit( 0 );
	}
}
