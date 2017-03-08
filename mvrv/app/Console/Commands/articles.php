<?php

namespace App\Console\Commands;

use App\Article;
use App\Category;
use Validator;

use Illuminate\Console\Command;

class articles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'article:input';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Input article base';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Article $article, Category $category)
    {
        parent::__construct();
        
        $this->article = $article;
        $this->category = $category;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
    	//cate
    	$cates = $this->category->all()->map(function($c){
        	return $c->name;
        })->all();
    	$cate = $this->choice('What is Category ?', $cates);
        $cateId = $this->category->where('name', $cate)->first()->id;

        
        //title
        $title = $this->ask('What is Title ?');
        
        //site
        $movieSite = $this->ask('What is Movie site ? (youtube, niconico, vimeo)');
		
        //url
        $movieUrl = $this->ask('What is Movie url ?');
        $movieUrl = rtrim($movieUrl, '/');
        
        
        $headers = ['入力内容'];
        $inputs = [array('カテゴリー: '.$cate), array('タイトル: '.$title), array('動画サイト: '.$movieSite), array('動画URL: '.$movieUrl)];
        $this->table($headers, $inputs);
        

        if ($this->confirm('Do you wish to save?')) {
        	
            $arr = ['cate_id'=>$cateId, 'title'=>$title, 'movie_site'=>$movieSite, 'movie_url'=>$movieUrl];
            
            $validator = Validator::make($arr, [
            	'cate_id' => 'required',
                'title' => 'required|max:255',
                'movie_site' => 'required|max:255',
                'movie_url' => 'required|max:255|unique:articles,movie_url',
            ]);
            
            if ($validator->fails()) {
            	$errors = $validator->errors()->all();
                $this->comment('Save Failed');
                foreach($errors as $error) {
                	$this->error($error);
                }
            }
            else {
                $atcl = $this->article->create(
                    [
                        'cate_id' => $cateId,
                        'title' => $title,
                        'movie_site' => $movieSite,
                        'movie_url' => $movieUrl,
                        
                        'owner_id' => 0,
                        'open_status' => 0,
                        'open_history' => 0,
                        'not_newdate' => 0,
                        'del_status' => 0,
                    ]
                );
                
                if($atcl) {
            		$this->info('Save Success!');
                }
                else {
                    $this->error('Save Failed');
       
                }
            }
            
        }
        
    }
}

