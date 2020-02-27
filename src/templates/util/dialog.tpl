<div class="im-dialog-block im-dialog-center im-dialog-box"  id="im_dialog">
    <section class="user-box dialog-box f_im_dialog_box">
        <div class="user-box-header">
            <span id="im_dialogTitle">
            </span>
            <a class="close-btn f_im_dialog_close" href="javascript:void(0);" title="close">
                <i class="material-icons prefix">close</i>
            </a>
        </div>
        <div class="user-box-content">
            <p id="im_dialogContent"></p>
            <br/><br/>
            <div class="f_confirmation-message-container">
                <span class="f_error-reason"></span><br>
                <label for="confirmationMessage">If you really want to delete item please type word "<span class="f_confirmation-required-text"></span>"</label>
                <input id="confirmationMessage" type="text" class="f_confirmation-message" value="" />
            </div>
            <input type="submit" value="OK" class="form-button-box f_im_ok_btn"/>
            <input type="submit" value="Cancel" class="form-button-box f_im_cancel_btn f_im_dialog_close"/>
        </div>
    </section>
    <section class="custom-box dialog-box im-dialog-custom-box" id="im_dialogContainer">

    </section>
    <section class="overlay-box" id="im_dialogOverlay"></section>
</div>
<section class="overlay-box-bg"></section>