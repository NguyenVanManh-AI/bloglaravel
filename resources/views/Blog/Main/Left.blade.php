<style>
    #dashboard_left {
    /* border: 1px solid red; */
    /* height: 100vh; */
    background-color: #F2F4F6;
}

.input-group-text {
    border-top-right-radius:20px !important;
    border-bottom-right-radius:20px !important;
    background-color: white;
    border-left: none;
    padding-left: 5px !important;
    color: silver;
}
#text_search {
    border-top-left-radius:20px;
    border-bottom-left-radius:20px;
    border-right: none;
    outline: none !important;
    transition: all 0s ease;
    padding-right: 0px !important;
}
#text_search:focus {
    outline: none !important;
    border-color: #4c90f5 !important;
}
.input-group:focus-within .input-group-text {
  border-color: #4c90f5;
}
.main_right {
    align-items: center;
}
.logo_blog {
    width: 12%;
    cursor: pointer;
}
.logo_blog img{
    width: 100%;
    object-fit: cover;
}
.form_search {
    padding-left:10px;
    width: 88%;
}

#list_search {
    margin-left: 10px;
    margin-right: 10px;
    padding: 5px 10px;
    background-color: white;
    border:1px solid silver;
    border-radius: 10px;
}
#inner_search {
    max-height: 80vh;
    overflow: hidden;
    overflow-y: scroll;
}

/* item_user */
.item_user {
    display: flex;
    align-items: center;
    border-radius: 10px;
    padding: 5px 10px;
    cursor: pointer;
}
.item_user:hover {
    background-color: #e4e4e4;
}
.item_user img {
    height: 40px;
    width: 40px;
    object-fit: cover;
    border-radius: 20px;
    margin-right: 10px;
}
.item_user span {
    font-weight: bold;
}

/* item_article */
.item_article {
    align-items: center;
    border-radius: 10px;
    padding: 10px 10px;
    padding-top: 5px;
    cursor: pointer;
    font-weight: bold;
    padding-left: 60px;

    /* Sử dụng kỹ thuật clamp() để giới hạn chiều cao */
    /* height: clamp(0px, 30px, auto); */
    max-height: 55px;
    
    /* Ẩn dấu ba chấm ban đầu */
    display: -webkit-box;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
    -webkit-line-clamp: 2; /* giới hạn số dòng */
    word-wrap: break-word;
    cursor: pointer;
}
.item_article:hover {
    background-color: #e4e4e4;
}

.no_result {
    display: flex;
    align-items: center;
    border-radius: 10px;
    padding: 5px 10px;
    justify-content: center;
    background-color: #e4e4e4;
    font-weight: bold;
}
.no_result i {
    margin-right: 10px;
}
.hidden {
    display: none !important;
}
</style>
<div id="dashboard_left">
    <div class="main_right col-12 d-flex pb-3" >
        <div class="logo_blog" ><img src="{{asset('Blog/image/logo.png')}}"/></div>
        <div class="form_search">
            <div class="input-group">
                <input type="text" class="shadow-none form-control" id="text_search" placeholder="Search name or title article">
                <div class="input-group-prepend">
                    <div class="input-group-text" ><i class="fa-solid fa-magnifying-glass"></i></div>
                </div>
            </div>
        </div>
    </div>
    <div class="row hidden" id="list_search" >
        <div class="col-12 p-1" id="inner_search">
            {{-- result search --}}

            {{-- result search --}}
        </div>
    </div>
</div>
<script src="{{asset('Blog/js/left.js')}}"></script>
