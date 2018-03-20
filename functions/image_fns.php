<?php


//去得当前ISBN的默认IMAGEID,如果有默认ID就提供默认ID，如果没有就选当前ISBN最小的IMAGEID作为默认ID。
function get_default_imageid($isbn){
    $db_conn= db_connect();
    //判断当前ISBN是否有图片，没有图片就报错。
	$query = "select image_id from images where isbn = '$isbn'";
	$result = $db_conn->query($query);
	if(!$result){
		return false;
	}
	$num = $result->num_rows;
	if($num == 0){
		return false;
	}
	
	//判断当前ISBN的默认IMAGEID是多少。
	$query = "select image_id from images where isbn = '$isbn' and default_image = '1'";
	$result = $db_conn->query($query);
	if(!$result){
		return false;
	}
	$num = $result->num_rows;
	$image_id = $result->fetch_assoc();
	$image_id = $image_id['image_id'];
	if($num == 1){		//如果有默认封面，就返回封面的ID
		return $image_id;
	}else{				//如果当前ISBN没有默认封面，就取ISBN中IMAGEID最小的作为默认封面
	
		$query = "select image_id from images where isbn = '$isbn' ORDER BY image_id";
		$result = $db_conn->query($query);
		if(!$result){
			return false;
		}
		$image_id = $result->fetch_row();
		$image_id = $image_id[0];
		
		return $image_id;
	}
}


//根据IMAGE_ID读取图片名称，以便展示
function get_image_name($image_id){
  	$db_conn= db_connect();

	$query = "select name from images where image_id = '$image_id'";
	$result = $db_conn->query($query);
	if(!$result){
		return false;
	}
	
	$num = $result->num_rows;
	$name = $result->fetch_assoc();
	$name = $name['name'];
	
	if($num == 0){
		return false;
	}
	return $name;
}



//读取当期ISBN的IMAGE_LIST.
function get_images_list($isbn){
	$db_conn= db_connect();

	$query = "select * from images where isbn = '$isbn' order by default_image desc";
	$result = $db_conn->query($query);
	if(!$result){
		return false;
	}
	$i = 0;
	while($array = $result->fetch_assoc()){
		$arr[$i]= $array;
		$i++;
	}
	return $arr;
}

//根据ISBN删除所有的图片，仅针对文件夹操作，先循环删除所有的文件，然后删除文件夹
function delete_all_images($isbn){
	$images_list = get_images_list($isbn);
	foreach($images_list as $no=>$array){
		$name = $array['name'];
		$path = "../images/$isbn/$name.jpg";
		if(file_exists($path)){
			if(!unlink($path)){
				return false;
			}
		}
	}
	if(!rmdir("../images/$isbn")){
		return false;
	}
	return true;
}



//根据图片ID读取ISBN
function get_isbn_byid($image_id){
	$db_conn= db_connect();
	
	$query = "select isbn from images where image_id = '$image_id'";
	$result = $db_conn->query($query);
	if(!$result){
		return false;
	}
	$result = $result->fetch_assoc();
	$isbn = $result['isbn'];
	
	return $isbn;
}
	
	
	
	
//删除图片，先读取对应的ISBN，删除对应的文件，然后删除数据库
function delete_img($image_id){
	$isbn = get_isbn_byid($image_id);
	$name = get_image_name($image_id);
	$path = "../images/$isbn/$name.jpg";
	
	if(!unlink($path)){
		return false;
	}
	
	$db_conn= db_connect();
	$query = "delete from images where image_id = '$image_id'";
	$result = $db_conn->query($query);
	if(!$result){
		return false;
	}
	return true;
}


//设置默认封面
function set_default_image($image_id){
//判断对应文件是否存在于数据库
	$db_conn= db_connect();
	
	$query = "select name from images where image_id = '$image_id'";
	$result = $db_conn->query($query);
	if(!$result){
		return 123;
	}
	$num = $result->num_rows;
	if($num ==0 ){
		return 234;
	}
//清空当前ISBN的所有图片的DEFAULT_IMAGE为0,
	$isbn = get_isbn_byid($image_id);
	$query = "update images set default_image = 0 where isbn = '$isbn'";
	$result = $db_conn->query($query);
	if(!$result){
		return 345;
	}
//将image_id设置为1；
	$query = "update images set default_image = 1 where image_id = '$image_id'";
	$result = $db_conn->query($query);
	if(!$result){
		return 456;
	}
	return true;
}







?>