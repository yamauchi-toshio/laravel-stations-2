<?php

namespace App\Http\Controllers;
use App\Models\Movie;
use App\Models\Genre;
use App\Models\Sheet;
use App\Models\Schedule;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Carbon\CarbonImmutable;


class MovieController extends Controller
{

    public function __construct()
    {
        $this->movie = new Movie();
    }

    ////////////////
    //一覧画面表示
    //
    public function ListMovies(Request $request)
    {
        $keyword = $request->input('keyword');              //title
        $is_showing = $request->input('is_showing');        //

        $query = Movie::query();

        if(!empty($keyword)) {
            $query->where('title', 'LIKE', "%{$keyword}%")
                ->orWhere('description', 'LIKE', "%{$keyword}%");
        }

        if(($is_showing == '0') || ($is_showing == '1') ) {
            //上映中
            $query->where('is_showing', 'LIKE', "%{$is_showing}%");
        }

//        $movies = $query->get();
        $movies = $query->paginate(20);

        $sheets = Sheet::all();

        return view('ListMovies', compact('movies', 'keyword', 'is_showing'));
    }

    ////////////////
    //座席一覧画面表示
    //
    public function ListSheets()
    {
        $sheets = Sheet::all();
        return view('ListSheets', compact('sheets'));
    }
    
    ////////////////
    //座席予約(No.17-2)
    //
    public function reservecreate($m_id ,$s_id ,Request $request)
    {

        $keyword = $request->date;
        if(empty($keyword)) {
            abort(400);
        }
        $keyword = $request->sheetId;
        if(empty($keyword)) {
            abort(400);
        }

        //登録済み検査
        $reserve=Reservation::where('schedule_id', $s_id)
                                ->where('sheet_id',$request->sheetId)
                                ->get();


        if (!$reserve->isEmpty()) {
            session()->flash('message', 'その座席はすでに予約済みです。');
//            abort(400);
            return back()->with('result', 'ok！');
//            return back()->withInput();     // 送信データがセッション内に格納される
        }


        try{
            //対象movie
            $movie = Movie::find($m_id);

            //対象スケジュール検索
            $schedule = Schedule::find($s_id);
            $schedule -> start_time_date = $schedule -> start_time->format('Y-m-d');
            $schedule -> start_time_time = $schedule -> start_time->format('H:i');
            $schedule -> end_time_date = $schedule -> end_time->format('Y-m-d');
            $schedule -> end_time_time = $schedule -> end_time->format('H:i');
            //座席一覧
            $sheets = Sheet::all();
        }catch (\Throwable $e){
//            abort(400);
        }
        return view('reservecreate', compact('movie','sheets','schedule','request'));
    }    

    ////////////////
    //(ユーザー)座席予約フォーム　→　保存
    //

    public function storesheet(Request $request)
    {

        //バリデーション
        $validated = $request->validate([
            'date' => 'required',
            'schedule_id' => 'required',
//            'sheet_id' => ['required','unique:reservations,sheet_id'],
            'screen_no' => 'required',
            'sheet_id' => 'required',
            'email' => 'email',
            'name' => 'required',
        ]);

        $reserve=Reservation::where('schedule_id', $request->schedule_id)
                                ->where('sheet_id',$request->sheet_id)
                                ->where('screen_no',$request->screen_no)
                                ->get();


        if (!$reserve->isEmpty()) {
            echo "その座席はすでに予約済みです。";
/*なんかNo.19でエラーが出る。一旦、コメントアウト(AA)
            return  redirect()
                ->route('reserve', ['m_id'=>$request->movie_id ,'s_id'=>$request->schedule_id ,'date'=>$request->date]);
(AA)*/
        }
       
        try{
            // トランザクション開始
            DB::beginTransaction();

            $reservation = new Reservation; //　インスタンス化
            
            $date =CarbonImmutable::now()->format('Y-m-d');
 
            $reservation->date              = $date;
            $reservation->schedule_id       = $request->schedule_id;
            $reservation->sheet_id          = $request->sheet_id;
            $reservation->email             = $request->email;
            $reservation->name              = $request->name;
            $reservation->screen_no         = $request->screen_no;
//            $reservation->is_canceled      = $FLG1; 

            $reservation->save();         //保存

            DB::commit();
            session()->flash('message', '予約が完了しました。');
        }catch (\Throwable $e){
            DB::rollback();
        }

//        //対象movie(17)
//        $movie = Movie::find($request->movie_id);
//        return redirect()->route('detail',['id'=>$request->movie_id]);
        return redirect()->route('list');       // ※本来の期待値ではない(17)
    }

    ///////////////////////////////
    //座席予約保存(管理者)　(19)
    //  post('/admin/reservations/'
    //
    public function adminstoresheet(Request $request)
    {

        //バリデーション
        $validated = $request->validate([
//            'date' => 'required',
            'movie_id' => 'required',
            'schedule_id' => 'required',
            'sheet_id' => 'required',
            'email' => 'email',
            'name' => 'required',
        ]);

        try{

            // トランザクション開始
            DB::beginTransaction();

            $reservation = new Reservation; //　インスタンス化
            
            $date =CarbonImmutable::now()->format('Y-m-d');

            $reservation->date              = $date;
            $reservation->schedule_id       = $request->schedule_id;
            $reservation->sheet_id          = $request->sheet_id;
            $reservation->email             = $request->email;
            $reservation->name              = $request->name;
        //            $reservation->is_canceled      = $FLG1; 

            $reservation->save();         //保存

            DB::commit();
            session()->flash('message', '予約が完了しました。');

        }catch (\Throwable $e){
            DB::rollback();
            session()->flash('message', '予約が失敗しました。');
            return redirect()->route('adminreserve');
        }

        return redirect()->route('admindetail' ,['id'=>$request->movie_id]);
    }

    
    ////////////////
    //映画詳細
    //
    public function detail($id)
    {
        //対象movie
        $movie = Movie::find($id);
        //ジャンルidで検索
        $genre = Genre::where('id', $movie->genre_id)->first();
        //movieにジャンル名を追加
        $movie -> genre_name = $genre -> name;
        
        //スケジュール情報
        $query = Schedule::query();
        $query->where('movie_id', $movie->id);
        $Schedules = $query->orderBy('start_time', 'asc')->get();
        $Schedules = $query->get();
        return view('detailMovies', compact('movie' ,'Schedules'));
    }                                                                                                                                                                  

    ////////////////
    //映画詳細(admin)
    //
    public function admindetail($id)
    {
        //対象movie
        $movie = Movie::find($id);
        //ジャンルidで検索
        $genre = Genre::where('id', $movie->genre_id)->first();
        //movieにジャンル名を追加
        $movie -> genre_name = $genre -> name;
        
        //スケジュール情報
        $query = Schedule::query();
        $query->where('movie_id', $movie->id);
        $schedules = $query->orderBy('start_time', 'asc')->get();
        $schedules = $query->get();

        //座席一覧
        $sheets = Sheet::all();

        return view('admindetailMovies', compact('movie' ,'schedules' ,'sheets'));
    }

    ////////////////
    //座席予約(No.17)
    //
    public function reserve($m_id ,$s_id ,Request $request)
    {

        $keyword = $request->date;
        if(empty($keyword)) {
            abort(400);
        }

        try{
            //対象movie
            $movie = Movie::find($m_id);
            //対象スケジュール検索
            $schedule = Schedule::find($s_id);
            $schedule -> start_time_date = $schedule -> start_time->format('Y-m-d');
            $schedule -> start_time_time = $schedule -> start_time->format('H:i');
            $schedule -> end_time_date = $schedule -> end_time->format('Y-m-d');
            $schedule -> end_time_time = $schedule -> end_time->format('H:i');
            //座席一覧
            $sheets = Sheet::all();
            //予約一覧
            $reservations = Reservation::all();

        }catch (\Throwable $e){
            abort(400);
        }
        return view('reserveSheets', compact('movie','sheets','schedule','reservations'));
    }    

    ////////////////
    //管理者予約一覧(adminreserve_19)
    //
    public function adminreserve()
    {
        //未来の分だけ抽出(なぜか全部持ってくる)
//        $reservations = Reservation::all();
        $reservations = Reservation::with(['schedule' => function ($query) {
	        $query->where('end_time', '>', date('Y-m-d H:i:s'));
        }])->get();

        return view('adminreserve', compact('reservations'));
    }

    ////////////////
    //管理者予約追加(adminreservecreate_19)
    public function adminreservecreate(Request $request)
    {
        if(empty($request->date)) {
            $reservations = Reservation::with(['schedule' => function ($query) {
                $query->where('end_time', '>', date('Y-m-d H:i:s'));
            }])->get();
            return view('adminreserve', compact('reservations'));
        }

        try{
            //対象movie
            $movie = Movie::find($request->movie_id);
            //対象スケジュール検索
            $schedule = Schedule::find($request->schedule_Id);
            //座席一覧
            $sheets = Sheet::all();
        }catch (\Throwable $e){
//            abort(400);
        }
        return view('adminreservecreate', compact('movie','sheets','schedule','request'));

    }



    ////////////////
    //表示 (index2)
    //
    public function getMovies()
    {
        $movie = Movie::all();
        return view('getMovies', ['movies' => $movie]);
    }

    // public function index()
    // {
    //     $movie = $this->movie->findAllBooks();
    //     return view('index', compact('movie'));
    // }

    ////////////////
    //登録
    //
    public function createMovies(Request $request)
    {
        $movie = Movie::all();
        return view('createMovies', ['movies' => $movie]);
    }
    
    ////////////////
    //スケジュール一覧
    //
    public function listSchedule()
    {
        $schedules = Schedule::all();
        foreach ($schedules as $schedule)
        {
            //対象movie
            $movie = Movie::find($schedule->movie_id);
            $schedule->title = $movie->title;
        }
        return view('listSchedule', compact('schedules'));
    }

    ////////////////
    //スケジュール詳細(admin/schedule)
    //
    public function adminSchedule($id)
    {
        $schedule = Schedule::find($id);
        if (is_null($schedule)){
            abort(404);
        }else{
            $movie = Movie::find($schedule->movie_id);
        }
        return view('adminSchedule', compact('movie' ,'schedule'));
    }
    
    ////////////////
    //スケジュール作成画面表示
    //
    public function createSchedule($id)
    {
        //対象movie
        $movie = Movie::find($id);

        $query = Schedule::query();
        $query->where('movie_id', $movie->id);
        $Schedules = $query->orderBy('start_time', 'asc')->get();
        $Schedules = $query->get();
        return view('createSchedule', compact('movie' ,'Schedules'));      
    }


    ////////////////
    //登録処理(スケジュール)
    //                                                                                                                                                  
    public function storeSchedule(Request $request)
    {        
        //バリデーション1
        $validated = $request->validate([
            'movie_id' => 'required',
            'start_time_date' => 'required|date_format:Y-m-d|before_or_equal:end_time_date',
            'start_time_time' => 'required|date_format:H:i|before:end_time_time',
            'end_time_date' => 'required|date_format:Y-m-d|after_or_equal:start_time_date',
            'end_time_time' => 'required|date_format:H:i|after:start_time_time',
        ]);

        $startTimeM = $request->start_time_time;
        $startTime = new Carbon($request->start_time_time);
        $tmp = strtotime($startTime .'+5 minute');
        $tmp = date('H:i',$tmp);
        $time2 = array('start_time_time' => $tmp);
        $request->merge($time2);
        //バリデーション2
        $validated = $request->validate([
            'start_time_time' => 'before:end_time_time',
            'end_time_time' => 'after:start_time_time',
        ]);
        //リセット(元の値に戻す)
        $time3 = array('start_time_time' => $startTimeM);
        $request->merge($time3);
    //    dd($request);

        try{
            // トランザクション開始
            DB::beginTransaction();

            //★通常登録
            $Schedule = new Schedule;   // インスタンス化
            $Schedule->movie_id         = $request->movie_id;
            $Schedule->start_time       = new CarbonImmutable($request->start_time_date . " " . $request->start_time_time);
            $Schedule->end_time         = new CarbonImmutable($request->end_time_date . " " . $request->end_time_time);
            $Schedule->screen_no        = $request->screen_no;
            $Schedule->save();          // 保存

            DB::commit();
        }catch (\Throwable $e){
            DB::rollback();
            abort(500);
        }

        //対象movie
        $movie = Movie::find($Schedule->movie_id);

        $query = Schedule::query();
        $query->where('movie_id', $movie->id);
        $Schedules = $query->orderBy('start_time', 'asc')->get();
        $Schedules = $query->get();
//        echo "(" . $Schedule->start_time . ")";
//        dd($Schedules);

//        return view('createSchedule', compact('movie' ,'Schedules'));      
        return redirect()->route('createSchedule',['id'=>$movie->id])->with(compact('movie' ,'Schedules'));
    }

    ////////////////
    //スケジュール削除
    //
    public function destroySchedule($id)
    {
        $Schedule = Schedule::find($id);
        if (is_null($Schedule)){
            abort(404);
        }else{
            $movie = Movie::find($Schedule->movie_id);
            $Schedule->delete();        
        }

        $query = Schedule::query();
        $query->where('movie_id', $movie->id);
        $Schedules = $query->orderBy('start_time', 'asc')->get();
        $Schedules = $query->get();
//        return view('createSchedule', compact('movie' ,'Schedules'));      
        return redirect()->route('createSchedule',['id'=>$movie->id])->with(compact('movie' ,'Schedules'));

}    

    ////////////////
    //スケジュール編集
    //
    public function editSchedule($id)
    {
        //対象スケジュール検索
        $schedule = Schedule::find($id);
        //スケジュールidでMovie検索
        $movie = Movie::where('id', $schedule->movie_id)->first();
        $schedule -> start_time_date = $schedule -> start_time->format('Y-m-d');
        $schedule -> start_time_time = $schedule -> start_time->format('H:i');
        $schedule -> end_time_date = $schedule -> end_time->format('Y-m-d');
        $schedule -> end_time_time = $schedule -> end_time->format('H:i');
        return view('editSchedule', compact('movie' , 'schedule'));
    }    

    ////////////////
    //スケジュール更新処理
    //
    public function updateSchedule(Request $request, $id)
    {
        //dd($request);
        //バリデーション
        $validated = $request->validate([
            'movie_id' => 'required',
            'start_time_date' => 'required|date_format:Y-m-d',
            'start_time_time' => 'required|date_format:H:i',
            'end_time_date' => 'required|date_format:Y-m-d',
            'end_time_time' => 'required|date_format:H:i',
        ]);

        $schedule = Schedule::find($id);

        try{
            // トランザクション開始
            DB::beginTransaction();

            $schedule->start_time       = new CarbonImmutable($request->start_time_date . " " . $request->start_time_time);
            $schedule->end_time         = new CarbonImmutable($request->end_time_date . " " . $request->end_time_time);

            $schedule->save();    

            DB::commit();
         }catch (\Throwable $e){
             DB::rollback();
             abort(500);
        }

        //対象movie
        $movie = Movie::find($schedule->movie_id);

        $query = Schedule::query();
        $query->where('movie_id', $movie->id);
        $Schedules = $query->orderBy('start_time', 'asc')->get();
        $Schedules = $query->get();
//        return view('createSchedule', compact('movie' ,'Schedules'));
        return redirect()->route('createSchedule',['id'=>$movie->id])->with(compact('movie' ,'Schedules'));
    }

    ////////////////
    //編集
    //
    public function edit($id)
    {
        //対象movie
        $movie = Movie::find($id);
        //ジャンルidで検索
        $genre = Genre::where('id', $movie->genre_id)->first();
        //movieにジャンル名を追加
        $movie -> genre_name = $genre -> name;
        return view('editMovies', compact('movie'));
    }    

    ////////////////
    //(19)管理者 予約編集
    //
    public function admineditSheet($id)
    {

        $Reservation = Reservation::find($id);
        if (is_null($Reservation)){
            abort(404);
        }else{
            return view('admineditSheet', compact('Reservation'));
        }
    }


    
    ////////////////
    //更新処理
    //
    public function update(Request $request, $id)
    {

        //バリデーション
         $validated = $request->validate([
             'title' => ['required','unique:movies,title'],
             'image_url' => 'required',
             'published_year' => 'required',
             'is_showing' => 'required',
             'description' => 'required',
             'genre' => 'required',
             'image_url' => 'url',
         ]);

         $movie = Movie::find($id);

        // リクエストデータを基に登録する
        if ($request->is_showing == true){
            $FLG1 = 1;
        }else{
            $FLG1 = 0;
        }

         try{
            // トランザクション開始
            DB::beginTransaction();

            //--- ジャンル情報登録 ---
            $genre = Genre::where('name', $request->genre)->first();

            if (empty($genre) == true) {
                $genre = new Genre;                 //インスタンス化
                $genre->name           = $request->genre;    
                $genre->save();                     //保存
                $genre = Genre::where('name', $request->genre)->first();
            };
            
            $movie->title           = $request->title;
            $movie->image_url       = $request->image_url;
            $movie->published_year  = $request->published_year;
            $movie->is_showing      = $FLG1;
            $movie->description     = $request->description;
            $movie->genre_id        = $genre->id ;
            $movie->save();    

            DB::commit();
         }catch (\Throwable $e){
             DB::rollback();
             abort(500);
        }

        return redirect()->route('list');
    }

    ////////////////
    //管理者座席更新処理
    //
    public function sheetupdate(Request $request, $id)
    {
        //バリデーション
         $validated = $request->validate([
            'movie_id' => 'required',
            'schedule_id' => 'required',
            'sheet_id' => 'required',
             'name' => 'required',
             'email' => 'required',
         ]);

         $Reservation = Reservation::find($id);

         try{
            // トランザクション開始
            DB::beginTransaction();
            
//            $Reservation->movie_id          = $request->movie_id;
            $Reservation->schedule_id       = $request->schedule_id;
            $Reservation->sheet_id          = $request->sheet_id;
            $Reservation->name              = $request->name;
            $Reservation->email             = $request->email;
            $Reservation->save();    

            DB::commit();
         }catch (\Throwable $e){
             DB::rollback();
        }

        return redirect()->route('adminreserve');
    }
    
    ////////////////
    //登録処理(映画)
    //
    public function store(Request $request)
    {
        
        //バリデーション
        $validated = $request->validate([
            'title' => ['required','unique:movies,title'],
            'image_url' => 'required',
            'published_year' => 'required',
            'is_showing' => 'required',
            'description' => 'required',
            'genre' => 'required',
            'image_url' => 'url',
        ]);

        // リクエストデータを基に登録する
        if ($request->is_showing == true){
            $FLG1 = 1;
        }else{
            $FLG1 = 0;
        }

        try{
            // トランザクション開始
            DB::beginTransaction();

            //--- ジャンル情報登録 ---
            $genre = Genre::where('name', $request->genre)->first();
            if (empty($genre) == true) {
                $genre = new Genre;                 //インスタンス化
                $genre->name           = $request->genre;    
                $genre->save();                     //保存
                $genre = Genre::where('name', $request->genre)->first();
            };

            //★通常登録
            $movie = new Movie; //　インスタンス化
            $movie->title           = $request->title;
            $movie->image_url       = $request->image_url;
            $movie->published_year  = $request->published_year;
            $movie->is_showing      = $FLG1;
            $movie->description     = $request->description;
            $movie->genre_id        = $genre->id ;

            $movie->save();         //保存

            DB::commit();
        }catch (\Throwable $e){
            DB::rollback();
            abort(500);
        }
        
        $movie = Movie::all();
        return redirect('/admin/movies/create');
    }

   
    ////////////////
    //削除
    //
    public function destroy($id)
    {
        $movie = Movie::find($id);
        if (is_null($movie)){
            abort(404);
        }else{
            $movie->delete();        
        }
        return redirect()->route('list');
    }    

    ////////////////
    //  (19)管理者予約削除
    //
    public function admindestroySheet($id)
    {
        $Reservation = Reservation::find($id);
        if (is_null($Reservation)){
            abort(404);
        }else{
            $Reservation->delete();        
        }
        return redirect()->route('adminreserve');
    }    
    

}