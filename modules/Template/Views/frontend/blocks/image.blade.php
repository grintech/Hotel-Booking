 <style type="text/css">
       .bravo_banner {
    background-color: #1a2b48;
    background-position: 50%;
    background-repeat: no-repeat;
    background-size: cover;
    padding: 100px 0;
    position: relative;
}
.bravo_banner h1{
        font-size: 36px;
    color: #fff;
    letter-spacing: 0;
    text-align: left;
    margin: 0;
}
   </style>
    @php

    $db = DB::table('core_languages')->get();
    $file_path = DB::table('media_files')->where('id',$bav)->select('file_path')->get();
    //dd($db);
    $result = array();
    foreach($db as $row1){
    //dd($row);
    $result[] = url($row1->locale.'/'.'page/become-a-vendor');
}
    //dd($result);
        $title_page = setting_item("news_page_list_title");
        if(!empty($custom_title_page)){
            $title_page = $custom_title_page;
        }
        //dump(  $_SERVER['REQUEST_URI']   );
        // echo url()->current();
          $res = explode('/',url()->current());
          //dd($res);
         $lng = url()->current();

         if(in_array($lng , $result)){
         //echo "df";
     }else{
     //echo "aa";
 }

//exit();
         //dd(url($lng.'/'.'page/become-a-vendor'));

        //dump(url()->current());
        //dump( url('page/become-a-vendor')  );
         //dump($lng );
         //dump($result);



    @endphp
    @if(url()->current() == url('page/become-a-vendor') or in_array($lng , $result))
        <div class="bravo_banner" style="background-image: url({{get_file_url($bav,'full')}})" >
            <div class="container">
                <h1>
                    {{ __("Become a vendor") }}
                </h1>
            </div>
        </div>
    @endif
