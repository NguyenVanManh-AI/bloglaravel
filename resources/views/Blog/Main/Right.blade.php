<style>
    #right_min {
        width: 100%;
        height: 70vh;
        padding: 0px 10px;
    }
    #show_modal {
        display: flex;
        justify-content: end;
        padding: 5px 10px;
        align-items: center;
        border: 1px solid silver;
        font-weight: bold;
        font-size: 18;
        border-radius: 10px;
        background-color: white;
        cursor: pointer;
    }
    #show_modal img {
        width: 40px;
        height: 40px;
        /* object-fit: contain; */
        object-position: center;
        border-radius: 40px;
        margin-left: 15px;
    }
    #modal_content {
        width: 25%;
        position: absolute;
        right: 0px;
        top: -145px;
    }
    #outner_modal {
        width: 100%;
        display: flex;
        justify-content: center;
    }
    #min_modal_content {
        width: 85%;
        background-color: white;
        box-shadow: rgba(0, 0, 0, 0.15) 0px 15px 25px, rgba(0, 0, 0, 0.05) 0px 5px 10px;
        border-radius: 10px;
        padding: 10px 20px !important;
        background-color: white;
    }
    /* #min_modal_content a {
        display: flex;
        align-items: center;
        width: 100%;
        height: 100%;
    }
    #min_modal_content a:hover {

    } */
    #min_modal_content a {
        text-decoration: none;
        color: black;
        display: flex;
        font-size: 14px;
        width: 100%;
        padding: 6px;
        font-weight: bold;
        border: 1px solid silver;
        margin: 5px 0px;
        border-radius: 10px;
        padding-left: 25px;
        cursor: pointer;
        align-items: center;
    }
    #min_modal_content a:hover {
        background-color: rgb(234, 234, 234);
        color: #0076e5;
        text-decoration: none;
    }
    #min_modal_content a span {
        background-color: rgb(210, 210, 210);
        border-radius: 20px;
        display: flex;
        height: 30px;
        width: 30px;
        padding: 3px;
        text-align: center;
        align-items: center;
        justify-content: center;
        margin-right: 10px;
    }
    #modalUser.modal.fade {
        background-color: transparent !important;
    }
</style>
<div id="right_min" >
    @if(auth()->check())
        <!-- Button trigger modal -->
        <div id="show_modal" data-toggle="modal" data-target="#modalUser">
            <span>{{auth()->user()->name}}</span> 
            @if(\Illuminate\Support\Str::startsWith(auth()->user()->avatar, 'http'))
                <img id="upload_img" src="{{ auth()->user()->avatar }}" >
            @else
                <img id="upload_img" src="{{ 'http://localhost:8000/' . auth()->user()->avatar }}" >
            @endif
        </div>
        <div class="modal fade" id="modalUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div id="modal_content" class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content" style="background-color: transparent;border: none;">
                    <div id="outner_modal">
                        <div id="min_modal_content">
                            <a href="{{ route('main.personal-page', ['id_user' => auth()->user()->id]) }}"><span><i class="fa-solid fa-user-check"></i></span>{{auth()->user()->name}}</a>
                            <a href="{{ route('infor.view-infor') }}"><span><i class="fa-solid fa-gear"></i></span> Personal page </a>
                            <a href=""><span><i class="fa-solid fa-question"></i></span> Help & Support </a>
                            <a href=""><span><i class="fa-solid fa-info"></i></span> Comments </a>
                            <a href="{{ route('logout') }}" ><span><i class="fa-solid fa-arrow-right-from-bracket"></i></span> Log out </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else 
    <div id="show_modal" data-toggle="modal" data-target="#modalUser">
        <a href="{{ route('login') }}" style="border-radius: 10px" type="button" class="btn btn-outline-primary"><i class="fa-solid fa-arrow-right-to-bracket mr-2"></i> Login</a>
    </div>
    @endif 
</div>