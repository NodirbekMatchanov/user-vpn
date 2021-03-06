$(document).ready(function () {

    var URLToArray = function(url){
        function parse_mdim(name, val, data){
            let params = name.match(/(\[\])|(\[.+?\])/g);
            if(!params)params = new Array();
            let tg_id = name.split('[')[0];


            if(!(tg_id in data)) data[tg_id] = [];
            var prev_data = data[tg_id];

            for(var i=0;i<params.length;i++){
                if(params[i]!='[]'){
                    let tparam = params[i].match(/\[(.+)\]/i)[1];
                    if(!(tparam in prev_data)) prev_data[tparam] = [];
                    prev_data = prev_data[tparam];
                }else{
                    prev_data.push([]);
                    prev_data = prev_data[prev_data.length-1];
                }

            }
            prev_data.push(val);

        }

        var request = {};
        var arr = [];
        var pairs = url.substring(url.indexOf('?') + 1).split('&');

        for (var i = 0; i < pairs.length; i++) {
            var pair = pairs[i].split('=');
            if(decodeURIComponent(pair[0]).indexOf('[')!=-1)
                parse_mdim(decodeURIComponent(pair[0]), decodeURIComponent(pair[1]), request);
            else
                request[decodeURIComponent(pair[0])] = decodeURIComponent(pair[1]);
        }

        //To-do here check array and simplifity it: if parameter end with one index in array replace it by value [0]

        return request;
    }

    var getParams = URLToArray(window.location.href);

    if(getParams.hasOwnProperty("promocode") && getCookie('promocode') === undefined) {
        setCookie('promocode', getParams.promocode, {secure: true, 'max-age': 3600 *24*30});
        setPromo(getParams.promocode)
        console.log(getCookie('promocode'))
    }
    if(getParams.hasOwnProperty("ref") && getCookie('promocode') === undefined) {
        setCookie('promocode', getParams.ref, {secure: true, 'max-age': 3600 *24*30});
        setPromo(getParams.ref)
        console.log(getCookie('promocode'))
    }

    function setPromo(promocode) {
        $.ajax({
            url: "/used-promocodes/visit-save",
            method: "GET",
            data: {
                visit: true,
                promocode: promocode
            }
        })
    }


    if ($('#kt_repeater_1').length) {
        $('#kt_repeater_1').repeater({
            initEmpty: false,

            defaultValues: {
                'text-input': 'foo'
            },

            show: function () {
                $(this).slideDown();
            },

            hide: function (deleteElement) {
                $(this).slideUp(deleteElement);
            }
        });
    }
    
    $(document).on('click','#7days',function () {
        setQuickDate(7);
    })
    $(document).on('click','#30days',function () {
        setQuickDate(30);
    })
    $(document).on('click','#90days',function () {
        setQuickDate(90);
    })
    $(document).on('click','#365days',function () {
        setQuickDate(365);
    })

    function getDateXDaysAgo(numOfDays, date = new Date()) {
        const daysAgo = new Date(date.getTime());
        daysAgo.setDate(date.getDate() + numOfDays);
        return daysAgo;
    }
    function setQuickDate(day) {
        const date = new Date();
        $('[name="Promocodes[expire]"]').val(getDateXDaysAgo(day,date).toISOString().split('T')[0])
        $('[name="Promocodes[date_start]"]').val(date.toISOString().split('T')[0])
    }

    $(document).on('click', '#usePromocode', function () {
        $.ajax({
            url: "/promocodes/use-code",
            method: "POST",
            data: {code: $('[name="promocode"]').val()}
        }).done(function (data) {
            data =  JSON.parse(data)
            if(data.result == 'error'){
                alert(data.error);
                return false;
            } else {
                alert(data.result);
                $('#usePromocode').addClass('hidden');
                $('#cancelPromocode').removeClass('hidden')
            }

        })
    })

    $(document).on('click', '#cancelPromocode', function () {
        $.ajax({
            url: "/promocodes/cancel-code",
            method: "POST",
            data: {code: $('[name="promocode"]').val()}
        }).done(function (data) {
            data =  JSON.parse(data)
            if(data.result == 'error'){
                alert(data.error);
                return false;
            } else {
                alert(data.result);
                $('#usePromocode').removeClass('hidden');
                $('#cancelPromocode').addClass('hidden')
            }

        })
    })

    $(document).on('click', '.logout_user', function () {
        let id = $(this).data('id');
        $.ajax({
            url: "/user-tokens/logout",
            method: "POST",
            data: {id: id}
        }).done(function (data) {
          alert('?????????? ????????????????');
        })
    })

    $(document).on('focusout', '[name="register-form[promocode]"]', function () {
        $('.valid-promocode').text('');
        $('.field-register-form-promocode').removeClass('has-error');
        $.ajax({
            url: "/promocodes/validation",
            method: "POST",
            data: {code: $('[name="register-form[promocode]"]').val(),email:$('[name="register-form[email]"]').val()}
        }).done(function (data) {
            data = JSON.parse(data);
            if(data.result == 'success'){
                $('.valid-promocode').html("<i>"+data.description+"</i>");
            }
            if(data.result == 'error'){
               setTimeout(function (){
                   $('.field-register-form-promocode').addClass('has-error');
               },500)
                $('.valid-promocode').text(data.error);
            }
        })
    })

    $(document).on('focusout', '[name="payer-promocode"]', function () {
        $('.promocode-payer-message._success').html('');
        $('.promocode-payer-message._error').html('');
        $.ajax({
            url: "/promocodes/validation",
            method: "POST",
            data: {code: $(this).val()}
        }).done(function (data) {
            data = JSON.parse(data);
            // ???????????????? ?????????????? ????????????????
            if(data.result == 'success'){
                $('.promocode-payer-message._success').html("???????????????? ?????????????? ????????????????");
                $('.prices-item._active').trigger('click');
            }
            if(data.result == 'error'){
                $('.promocode-payer-message._error').html(data.error);
                $('.prices-item._active').trigger('click');
            }
        })
    })

    function setCookie(name, value, options = {}) {

        options = {
            path: '/',
        };
        if (options.expires instanceof Date) {
            options.expires = options.expires.toUTCString();
        }

        let updatedCookie = encodeURIComponent(name) + "=" + encodeURIComponent(value);

        for (let optionKey in options) {
            updatedCookie += "; " + optionKey;
            let optionValue = options[optionKey];
            if (optionValue !== true) {
                updatedCookie += "=" + optionValue;
            }
        }

        document.cookie = updatedCookie;
    }

    function getCookie(name) {
        let matches = document.cookie.match(new RegExp(
            "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
        ));
        return matches ? decodeURIComponent(matches[1]) : undefined;
    }

    $(document).on("change",'[name="email-payer"]',function (){
        $('.email-payer-message').closest('.input-2').removeClass('_error');
        $('.email-payer-message').html('');

        if(!ValidateEmail($(this)[0])) {
            $('.email-payer-message').html('?????????????????? ???????????????????????? ?????????? email ????????????');
        }
        if($(this).val() == ''){
            $('.email-payer-message').closest('.input-2').addClass('_error');
            $('.email-payer-message').html('???? ?????????????????? ???????? e-mail');
        }
     })

    $(document).on("click",'.auto-signup',function (){
        let element = $('[name="email"]')[0];
        $('[name="email"]').removeClass('validate-email');
        $('.error-email').remove();
        if(ValidateEmail(element)){
            let password = Password.generate(8);
            $.ajax({
                url: "/user/registration/auto-register",
                method: "GET",
                data: {password: password, password_repeat: password, email: element.value}
            }).done(function (data) {
                    if(data) {
                        alert('registrated')
                    }
            }).fail(function () {
                alert('???????????? ??????????????????????')
            })
        } else {
            $('[name="email"]').addClass('validate-email');
            $('[name="email"]').after("<span class='error-email' style='color: red; font-size: 14px'>?????????????????? ???????????????????????? ?????????? email ????????????</span>")
        }
    })

    /* email validate */
    function ValidateEmail(input) {

        var validRegex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;

        if (input.value.match(validRegex)) {


            return true;

        } else {

            return false;

        }

    }

    /* generatePassword */

    var Password = {

        _pattern : /[a-zA-Z0-9_\-\+\.]/,


        _getRandomByte : function()
        {
            // http://caniuse.com/#feat=getrandomvalues
            if(window.crypto && window.crypto.getRandomValues)
            {
                var result = new Uint8Array(1);
                window.crypto.getRandomValues(result);
                return result[0];
            }
            else if(window.msCrypto && window.msCrypto.getRandomValues)
            {
                var result = new Uint8Array(1);
                window.msCrypto.getRandomValues(result);
                return result[0];
            }
            else
            {
                return Math.floor(Math.random() * 256);
            }
        },

        generate : function(length)
        {
            return Array.apply(null, {'length': length})
                .map(function()
                {
                    var result;
                    while(true)
                    {
                        result = String.fromCharCode(this._getRandomByte());
                        if(this._pattern.test(result))
                        {
                            return result;
                        }
                    }
                }, this)
                .join('');
        }

    };

    /* ?????????????????? ???????????? */

    $(document).on('click','.send-question',function () {
        let email = "", question = "", name = "";
        name = $('[name="Questions[name]"]').val();
        email = $('[name="Questions[email]"]').val();
        question = $('[name="Questions[text]"]').val();
        $('.question-name').text('');
        $('.question-email').text('');
        $('.question-question').text('');

        validate = true;
        if(name === '') {
            validate = false;
            $('.question-name').text('???????????????????? ?????????????????? ??????????.')
        }
        if(email === '') {
            validate = false;
            $('.question-email').text('???????????????????? ?????????????????? ??email??.')
        }
        if(question === '') {
            validate = false;
            $('.question-question').text('???????????????????? ?????????????????? ????????????????.')
        }
        if(validate) {

            $.ajax({
                url: "/site/question",
                method: "POST",
                data: {email: email, name: name, text: question}
            }).done(function (data){
                $('.mfp-close').trigger('click')
                if(data) {
                    swal({
                        title: "?????? ???????????? ??????????????????",
                        text:"?????? ???????????? ??????????????????!",
                        icon:"success",
                    });
                } else {

                }
            }).fail(function () {
                $('.mfp-close').trigger('click')
            })
        }

    })

})