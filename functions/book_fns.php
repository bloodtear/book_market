<?php


//////////////////////////
//取得所有的书籍目录列表
//////////////////////////
function get_categories(){
    $db = db_connect();
    $query = "select catid,catname from categories";
    $result = $db->query($query);
    if(!$result){
        return false;
    }
    $num_cuts = $result->num_rows;//取出的数据是否为空
    if($num_cuts == 0 ){
        return false;
    }
    $i = 0;
    $j = 0;
    while($array = $result->fetch_array()){//依次把数据拿出来
        $cat_arr[$i][$j] = $array[0];
        $cat_arr[$i][$j+1] = $array[1];
        $i++;
    }
    return $cat_arr;
}


///////////////////////////////////
//根据目录ID取出目录名称
///////////////////////////////
function get_categories_name($catid){

    $db = db_connect();
    $query = "select catname from categories where catid = '".$catid."'";
    $result = $db->query($query);
    if(!$result){
        return false;
    }
    $num_cuts = $result->num_rows;//取出的数据是否为空
    if($num_cuts == 0 ){
        return false;
    }
    $catname = $result->fetch_row();    //取出数据
    return $catname[0];
}

///////////////////////////////////
//根据目录名称取出目录ID
///////////////////////////////
function get_categories_id($cat){

    $db = db_connect();
    $query = "select catid from categories where catname = '".$cat."'";
    $result = $db->query($query);
    if(!$result){
        return false;
    }
    $num_cuts = $result->num_rows;//取出的数据是否为空
    if($num_cuts == 0 ){
        return false;
    }
    $catid = $result->fetch_row();    //取出数据
    return $catid[0];
}

/////////////////////////////////////////
//根据目录ID判断是否此目录下有书籍，
//如果没有返回false,有就返回书籍的包含量。
/////////////////////////////////////////
function contain_books($catid){

    $db = db_connect();
    $query = "select isbn from books where catid = '".$catid."'";
    $result = $db->query($query);
    if(!$result){
        throw new Exception('抱歉，查询数据库失败10001');
    }
    $num = $result->num_rows;//取出的数据是否为空
    if($num == 0){
        return false;
    }else{
        return $num;
    }
}


//////////////////////////////
//取出特定目录中的所有书籍
///////////////////////////
function get_books($catid){

    $db = db_connect();
    
    $query = "select isbn,title from books where catid = '".$catid."'";
    $result = $db->query($query);
    if(!$result){
        return false;
    }
    $num_cuts = $result->num_rows;//取出的数据是否为空
    if($num_cuts == 0 ){
        return false;
    }
    $i = 0;
    $j = 0;
    while($array = $result->fetch_array()){//依次把数据拿出来
        $books[$i][$j] = $array[0];
        $books[$i][$j+1] = $array[1];
        $i++;
    }
    return $books;
}


//////////////////////////
//取得单个图书的细节by isbn
/////////////////////////////
function get_book_detail($isbn){
    $db = db_connect();
    $query = "select * from books where isbn = '".$isbn."'";
    $result = $db->query($query);
    if(!$result){
        return false;
    }
    $num_cuts = $result->num_rows;//取出的数据是否为空
    if($num_cuts == 0 ){
        return false;
    }
    
    $book_array = $result->fetch_assoc();   //取出关联数组
    return $book_array;
}


//////////////////////////////////////
//取得num数量的书籍的isbn和title和author
//////////////////////////////////////
function get_books_bynum(){

    $db = db_connect();
    
    $query = "select isbn,title,author from books";
    $result = $db->query($query);
    if(!$result){
        return false;
    }
    $num_cuts = $result->num_rows;//取出的数据是否为空
    if($num_cuts == 0 ){
        return false;
    }
    $i=0;
    while($array = $result->fetch_assoc()){
        $arr[$i] = $array;
        $i++;
    }
    return $arr;
}


/////////////////
//上传文件
///////////////////////
function upload_image($error,$name,$type,$tmp_name,$size,$isbn){
    
    //先判断上传动作是否有错误，从错误码判断。
    if($error>0){
        switch($error){
            case 1:throw new Exception("上传文件大小超过约定值，PHP文件中设定的upload_max_filesize");
                break;
            case 2:throw new Exception("文件大小超过了htmL中的限制");
                break;
            case 3;throw new Exception("表示文件只被部分上传");
                break;
            case 4;throw new Exception( "没有上传任何文件");
                break;
            case 6;throw new Exception( "无法上传文件：找不到指定的临时存储位置");
                break;
            case 7;throw new Exception( "上传文件失败：无法写入硬盘中");
                break;
        }
    }

    //判断文件类型，是否是文档类。还有其他类,如图片等
    if(($type !== 'image/jpeg') && ($type !== 'image/pjpeg')){
        throw new Exception( "出现问题：上传的文件不是jpg文件");
    }
    
    //由于临时存储目录中的文件,php解析完成之后会自动删除，我们需要将文件转移到其他目录
	$name = uniqid('','true');
    $saveto = "../images/$isbn/$name.jpg";
    //upfile变量存储文件，实际上就是路径拼上文件名称。
	
	//判断文件夹目录是否存在，如果不存在，就创建
	$save_path = "../images/$isbn/";
	if(!file_exists($save_path)){
		mkdir($save_path, 0777);
	}

    if(file_exists($saveto)){   //判断文件是否存在.如果有同名文件，就添加对应的名称
		echo "文件已经存在<br>";
        $name 	= $name.'1';
		$saveto = '../images/'.$name.'.jpg';
    }

    if(is_uploaded_file($tmp_name)){   //判断文件是否是上传过来的。而不是本地的文件。这个我试了很多次，现阶段没法把结果搞成false
        if(!move_uploaded_file($tmp_name,$saveto)){   //移动文件，并且判断文件是否移动成功
            throw new Exception( "出现问题：无法将文件移动到指定位置");
        }
    }else{
        throw new Exception( "出现问题：可能文件上传中断，文件名称：");
        echo $name;
    }
    return $name;
}

///////////////////////////////////////
//新增图片，在数据库中，需要名称以及isbn号,还有是否是默认值。
//////////////////////////////////////
function add_image_sql($isbn,$new_name,$default){
    $db = db_connect();
	//var_dump($default);
	//看是否有重名的。
    $query = "select name from images where name = '".$new_name."'";
    $result = $db->query($query);
    if(!$result){
        return false;
    }
    $num = $result->num_rows;
    if($num > 0 ){
        return false;
    }
	
	//如果设置默认封面，就必须要先清除当前ISBN的所有DEFAULT制为0.如果当前ISBN有图片的话。
	$query = "select name from images where isbn = '$isbn'";
    $result = $db->query($query);
    if(!$result){
        return 123311;
    }
    $num_has = $result->num_rows;
    if($num_has > 0 ){
       if($default == 1){
		$query =  "update images set default_image = '0' where isbn = '$isbn'";
		$result = $db->query($query);
		if(!$result){
        	return 3344433;
    	}
		}
    }
	
	
	//插入动作
	$query = "insert into images values ('','$new_name','$isbn','$default')";
    $result = $db->query($query);
	if(!$result){
        return 444444;
    }
	return true;
}

////////////////////////////////
//检查是否数据库中已经存在这个ISBN了
//////////////////////////////
function is_isbn_exist($isbn){
    $db = db_connect();

    $query = "select isbn from books where isbn = '".$isbn."'";
    $result = $db->query($query);
    if(!$result){
        return false;
    }
    $num = $result->num_rows;//取出的数据是否为空
    if($num == 0 ){
        return false;
    }else{
        return true;
    }
}
    

/////////////////////////////////
//检查是否数据库中已经存在这个CAT类别了 
////////////////////////////////////
function is_cat_exist($cat){
    $db = db_connect();

    $query = "select catname from categories where catname = '".$cat."'";
    $result = $db->query($query);
    if(!$result){
        return false;
    }
    $num = $result->num_rows;//取出的数据是否为空
    if($num == 0 ){
        return false;
    }else{
        return true;
    }
    }


///////////////////////////////////////////////
//添加这个类别到categories表内 ,并返回新添加的catid.
/////////////////////////////////////////////////
function add_cat($cat){
    $db = db_connect();

    $query = "insert into categories values ('','".$cat."')";
    $result = $db->query($query);
    if(!$result){
        throw new Exception('插入CATNAME新的动作失败');
    }
    
    $query = "select catid from categories where catname = '".$cat."'";
    $result = $db->query($query);
    if(!$result){
        return false;
    }
    $catid = $result->fetch_array();
    
    return $catid[0];
    
}


///////////////////////////////////////////////
//删除书籍by isbn.
/////////////////////////////////////////////////
function delete_book($isbn){
    $db = db_connect();
    //以上为数据库的删除，还需要将对应的文件夹下的图片全部删除
	//删除所有的文件
	if(!delete_all_images($isbn)){
		return false;
	}
    $query = "select isbn from books where isbn = '".$isbn."'";
    $result = $db->query($query);
    if(!$result){
        throw new Exception("抱歉，查询动作失败：".$isbn."");
    }
    $num = $result->num_rows;
    if($num == 0){
        throw new Exception("抱歉，没有查询到这个图书：".$isbn."");
    }
    
    $query = "delete from books where isbn = '".$isbn."'";
    $result = $db->query($query);
    if(!$result){
        throw new Exception("删除书籍动作失败：".$isbn."");
    }
	

    return true;
}

////////////////////////////////////////////////////////////
//新增书籍到books里面 ,需要提供ISBN，作者，标题，类别ID,价格，描述
//////////////////////////////////////////////////////////
function add_book($isbn,$author,$title,$catid,$price,$description){
    $db = db_connect();

    $query = "insert into books values 
    ('".$isbn."','".$author."','".$title."','".$catid."','".$price."','".$description."')";
    $result = $db->query($query);
    if(!$result){
        return false;
    }
    return true;
}

////////////////////////////////////////////////////////////
//修改book里面的一个book的信息 ,需要提供ISBN，作者，标题，类别ID,价格，描述
//////////////////////////////////////////////////////////
function modify_book($isbn,$author,$title,$catid,$price,$description){
    $db = db_connect();

    $query = 
        "update books set 
        author = '".$author."',
        title = '".$title."',
        catid = '".$catid."',
        price = '".$price."',
        description = '".$description."'
        where isbn = '".$isbn."'";
   
    $result = $db->query($query);
    if(!$result){
        return false;
    }
    return true;
}




?>