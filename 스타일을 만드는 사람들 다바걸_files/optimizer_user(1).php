/**
 * 움직이는 배너 Jquery Plug-in
 * @author  cafe24
 */
/*
(function($){

    $.fn.floatBanner = function(options) {
        options = $.extend({}, $.fn.floatBanner.defaults , options);

        return this.each(function() {
            var aPosition = $(this).position();
            var jbOffset = $(this).offset();
            var node = this;

            $(window).scroll(function() {
                var _top = $(document).scrollTop();
                _top = (aPosition.top < _top) ? _top : aPosition.top;

                setTimeout(function () {
                    var newinit = $(document).scrollTop();

                    if ( newinit > jbOffset.top ) {
                        _top -= jbOffset.top;
                        var container_height = $("#wrap").height();
                        var quick_height = $(node).height();
                        var cul = container_height - quick_height;
                        if(_top > cul){
                            _top = cul;
                        }
                    }else {
                        _top = 0;
                    }

                    $(node).stop().animate({top: _top}, options.animate);
                }, options.delay);
            });
        });
    };

    $.fn.floatBanner.defaults = {
        'animate'  : 500,
        'delay'    : 500
    };

})(jQuery);
*/


/**
 * 문서 구동후 시작 2019-06-11
 */
$(document).ready(function(){

	//존재하지 않는 #banner, #quick 값으로 인한 로그인페이지등의 오류발생으로 주석처리
	//$('#banner:visible, #quick:visible').floatBanner();

    //placeholder
    $(".ePlaceholder input, .ePlaceholder textarea").each(function(i){
        var placeholderName = $(this).parents().attr('title');
        $(this).attr("placeholder", placeholderName);
    });
    /* placeholder ie8, ie9 */
    $.fn.extend({
        placeholder : function() {
            //IE 8 버전에는 hasPlaceholderSupport() 값이 false를 리턴
           if (hasPlaceholderSupport() === true) {
                return this;
            }
            //hasPlaceholderSupport() 값이 false 일 경우 아래 코드를 실행
            return this.each(function(){
                var findThis = $(this);
                var sPlaceholder = findThis.attr('placeholder');
                if ( ! sPlaceholder) {
                   return;
                }
                findThis.wrap('<label class="ePlaceholder" />');
                var sDisplayPlaceHolder = $(this).val() ? ' style="display:none;"' : '';
                findThis.before('<span' + sDisplayPlaceHolder + '>' + sPlaceholder + '</span>');
                this.onpropertychange = function(e){
                    e = event || e;
                    if (e.propertyName == 'value') {
                        $(this).trigger('focusout');
                    }
                };
                //공통 class
                var agent = navigator.userAgent.toLowerCase();
                if (agent.indexOf("msie") != -1) {
                    $(".ePlaceholder").css({"position":"relative"});
                    $(".ePlaceholder span").css({"position":"absolute", "padding":"0 4px", "color":"#878787"});
                    $(".ePlaceholder label").css({"padding":"0"});
                }
            });
        }
    });

    $(':input[placeholder]').placeholder(); //placeholder() 함수를 호출

    //클릭하면 placeholder 숨김
    $('body').delegate('.ePlaceholder span', 'click', function(){
        $(this).hide();
    });

    //input창 포커스 인 일때 placeholder 숨김
    $('body').delegate('.ePlaceholder :input', 'focusin', function(){
        $(this).prev('span').hide();
    });

    //input창 포커스 아웃 일때 value 가 true 이면 숨김, false 이면 보여짐
    $('body').delegate('.ePlaceholder :input', 'focusout', function(){
        if (this.value) {
            $(this).prev('span').hide();
        } else {
            $(this).prev('span').show();
        }
    });

    //input에 placeholder가 지원이 되면 true를 안되면 false를 리턴값으로 던져줌
    function hasPlaceholderSupport() {
        if ('placeholder' in document.createElement('input')) {
            return true;
        } else {
            return false;
        }
    }
});


/**
 *  썸네일 이미지 엑박일경우 기본값 설정
 */
 /*
$(window).load(function() {
    $("img.thumb,img.ThumbImage,img.BigImage").each(function($i,$item){
        var $img = new Image();
        $img.onerror = function () {
                $item.src="//img.echosting.cafe24.com/thumb/img_product_big.gif";
        }
        $img.src = this.src;
    });
});
*/


/**
 *  tooltip
 */
$('.eTooltip').each(function(i){
    $(this).find('.btnClose').attr('tabIndex','-1');
});
//tooltip input focus
$('.eTooltip').find('input').focus(function() {
    var targetName = returnTagetName(this);
    targetName.siblings('.ec-base-tooltip').show();
});
$('.eTooltip').find('input').focusout(function() {
    var targetName = returnTagetName(this);
    targetName.siblings('.ec-base-tooltip').hide();
});
function returnTagetName(_this){
    var ePlacename = $(_this).parent().attr("class");
    var targetName;
    if(ePlacename == "ePlaceholder"){ //ePlaceholder 대응
        targetName = $(_this).parents();
    }else{
        targetName = $(_this);
    }
    return targetName;
}

/**
 *  eTab
 */
 $("body").delegate(".eTab a", "click", function(e){
    // 클릭한 li 에 selected 클래스 추가, 기존 li에 있는 selected 클래스는 삭제.
    var _li = $(this).parent("li").addClass("selected").siblings().removeClass("selected"),
    _target = $(this).attr("href"),
    _siblings = $(_target).attr("class"),
    _arr = _siblings.split(" "),
    _classSiblings = "."+_arr[0];

    //클릭한 탭에 해당하는 요소는 활성화, 기존 요소는 비활성화 함.
    $(_target).show().siblings(_classSiblings).hide();


    //preventDefault 는 a 태그 처럼 클릭 이벤트 외에 별도의 브라우저 행동을 막기 위해 사용됨.
    e.preventDefault();
});



//window popup script
function winPop(url) {
    window.open(url, "popup", "width=300,height=300,left=10,top=10,resizable=no,scrollbars=no");
}
/**
 * document.location.href split
 * return array Param
 */
function getQueryString(sKey)
{
    var sQueryString = document.location.search.substring(1);
    var aParam       = {};

    if (sQueryString) {
        var aFields = sQueryString.split("&");
        var aField  = [];
        for (var i=0; i<aFields.length; i++) {
            aField = aFields[i].split('=');
            aParam[aField[0]] = aField[1];
        }
    }

    aParam.page = aParam.page ? aParam.page : 1;
    return sKey ? aParam[sKey] : aParam;
};

$(function(){
    // tab
    $.eTab = function(ul){
        $(ul).find('a').on('click', function(){
            var _li = $(this).parent('li').addClass('selected').siblings().removeClass('selected'),
                _target = $(this).attr('href'),
                _siblings = '.' + $(_target).attr('class');
            $(_target).show().siblings(_siblings).hide();
            return false
        });
    }
    if ( window.call_eTab ) {
        call_eTab();
    };
});
/*
  2021-02-06 카페24 베이스(/js/common.js)
*/
//window popup script
function winPop(url) {
    window.open(url, "popup", "width=300,height=300,left=10,top=10,resizable=no,scrollbars=no");
}

/**
 * document.location.href split
 * return array Param
 */
var getQueryString = function(sKey)
{
    var sQueryString = document.location.search.substring(1);
    var aParam = {};

    if (sQueryString) {
        var aFields = sQueryString.split("&");
        var aField  = [];
        for (var i=0; i<aFields.length; i++) {
            aField = aFields[i].split('=');
            aParam[aField[0]] = aField[1];
        }
    }

    aParam.page = aParam.page ? aParam.page : 1;
    return sKey ? aParam[sKey] : aParam;
};

$(document).ready(function(){
    // tab
    $.eTab = function(ul){
        $(ul).find('a').click(function(){
            var _li = $(this).parent('li').addClass('selected').siblings().removeClass('selected'),
                _target = $(this).attr('href'),
                _siblings = '.' + $(_target).attr('class');
            $(_target).show().siblings(_siblings).hide();
            return false
        });
    }
    if ( window.call_eTab ) {
        call_eTab();
    };
});


/*
  2021-01-01 디자인플로어 설정변수
*/
var setSize = 340;
var DF = {};

DF['ins-banking-li'] = {};
DF['ins-banking-p'] = {};

DF['set-prlmain-type'] = {};
DF['set-prlmain-view'] = {};
DF['set-prlmain-grid'] = {};
DF['set-prlmain-btn'] = {};

DF['set-prlrcmd-type'] = {};
DF['set-prlrcmd-view'] = {};
DF['set-prlrcmd-grid'] = {};
DF['set-prlrcmd-btn'] = {};

DF['set-prlnorm-type'] = {};
DF['set-prlnorm-view'] = {};
DF['set-prlnorm-grid'] = {};
DF['set-prlnorm-btn'] = {};

DF['set-prlproj-type'] = {};
DF['set-prlproj-view'] = {};
DF['set-prlproj-grid'] = {};
DF['set-prlproj-btn'] = {};

DF['set-prlsrch-type'] = {};
DF['set-prlsrch-view'] = {};
DF['set-prlsrch-grid'] = {};
DF['set-prlsrch-btn'] = {};

/*==========================================================================================================

	■ 디자인플로어 설정화면 ■
	- 본 화면에서 다양한 기능을 설정할 수 있습니다. 수정후 [저장]을 클릭하면 적용됩니다.

	■ [중요] 수정 참고사항 ■
	- 설정하실 각 항목의 쌍따옴표("") 안의 내용만 수정하세요.
    - 쌍따옴표("") 안에 다시 쌍따옴표를 입력하면 오류가 발생합니다.
	- 내용 입력시 엔터키를 입력하지마세요. 쇼핑몰 전체에 문제가 발생합니다.

	■ 문제 발생시 해결방법 ■
	- 본 화면 수정 중 문제가 발생한 경우 아래 방법으로 복구합니다.
	- 방법 ①: /dfloor/setup_backup.js 내용 전체를 이곳에 붙여넣기 하면 초기상태로 복구됩니다.
	- 방법 ②: 디자인관리 > 백업·복구에서 백업된 디자인을 복구하면 이전 내용으로 복구됩니다.

==========================================================================================================*/




/**********************************************************************************************************

	1.말풍선 문구

	- 로그인전 회원가입버튼 아래에 보여지는 말풍선아이콘입니다.
	- 가입시 증정할 적립금 및 기타문구를 짧게 입력하여 활용하실 수 있습니다.

**********************************************************************************************************/

//말풍선 아이콘 표시여부
DF['use-msgbox'] = "on";

//말풍선 아이콘내 표시문구
DF['rep-msgbox-txt'] = "+10,000 P";




/**********************************************************************************************************

	2.고객센터 운영시간

	- 쇼핑몰에 보여질 고객센터 운영시간을 수정해주세요.
	- 내용이 긴경우 아래 작성예와 같이 줄바꿈 태그 <br> 을 이용하여 작성하세요.

	[작성예]
	평일 오전10시~오후5시 <br> 점심 오후12시 ~ 오후1시 <br> 공휴일 휴무

**********************************************************************************************************/

//고객센터 운영시간을 입력해주세요.
DF['rep-cstime-txt'] = "평일 오전 10:00 ~ 오후 5:00 / 점심시간 오후 12:00 ~ 오후 1:00 / 토, 일, 공휴일 휴무";




/**********************************************************************************************************

	3.교환/반품지 주소

	- 쇼핑몰 하단에 표시되는 교환/반품지주소 정보를 입력하세요.
	- 사용하지 않을 경우 "절대 삭제하지 마시고 대체 문구를 입력"하여 활용하세요.

**********************************************************************************************************/

//표시 타이틀
DF['rep-returnex-tit'] = "RETURN / EXCHANGE";

//첫번째줄 표시문구
DF['rep-returnex-txt1'] = "CJ대한통운 : 서울시 성북구 숭인로14, 1층 CJ대한통운 '다바걸'";

//두번째줄 표시문구
DF['rep-returnex-txt2'] = "한진택배 : 서울시 종로구 지봉로 37-29, 913호 한진택배 '다바걸' ";




/**********************************************************************************************************

	4.입금계좌 정보

	- 쇼핑몰 하단에 표시되는 계좌번호 혹은 결제수단을 아래 항목에서 수정해주세요.
	- 쌍따옴표("") 안에 표시될 계좌번호 및 예금주명을 입력하시면 됩니다.
	- 계좌번호를 추가는 DF['ins-banking-li'][다음숫자] = ""; 소스를 마지막줄에 추가하세요.
	- 추가된 소스에서 [다음숫자] 부분을 다음숫자로(1234순) 입력해주세요.

	[글로벌 PG업체 목록]
	글로벌 쇼핑몰인 경우 계좌번호 대신 사용하는 결제수단을 표시하세요.
	신용카드 : CREDIT/DEBIT CARD
	페이팔   : PAYPAL
	엑심베이 : EXIMBAY
	엑시즈   : AXES
	알리페이 : ALIPAY

**********************************************************************************************************/

//입금계좌 정보(혹은 결제수단)
DF['ins-banking-li'][1] = "우리 1005-101-335115";
DF['ins-banking-li'][2] = "농협 1141-01-057383";
DF['ins-banking-li'][3] = "국민 729601-04-138751";
DF['ins-banking-li'][4] = "신한 100-024-368599";
DF['ins-banking-li'][5] = "기업 039-053616-01-012";
DF['ins-banking-li'][6] = "주식회사 엠제이앤엠(MJ&M) ";




/**********************************************************************************************************

	5.메인 슬라이드 배너

	- 메인 슬라이드 배너의 다양한 설정을 하실 수 있습니다.
	- 동영상을 등록할 경우 디자인매뉴얼을 확인해주세요.

**********************************************************************************************************/

//배너 표시 위치
//입력값: top        (슬라이드배너가 사이트의 최상단에서 부터 시작됩니다.)
//입력값: normal     (슬라이드배너가 상품분류메뉴 아래에서 시작됩니다.)
DF['set-mainslider-position'] = "normal";

//배너 전환효과
//입력값: fade  (다음사진으로 페이드 되며 전환됩니다.)
//입력값: slide (다음사진으로 슬라이드 되며 전환됩니다.)
DF['set-mainslider-effect'] = "fade";

//배너 페이징버튼 디자인설정하기
//입력값: circle      (페이징 버튼이 동그라미 모양으로 표시됩니다.)
//입력값: circle+wide (페이징 버튼이 동그라미 + 활성버튼 와이드로 표시됩니다.)
//입력값: square      (페이징 버튼이 정사각형 모양으로 표시됩니다.)
//입력값: square+wide (페이징 버튼이 정사각형 + 활성버튼 와이드로 표시됩니다.)
//입력값: stick       (페이징 버튼이 막대 직사각형 모양으로 표시됩니다.)
//입력값: stick+wide  (페이징 버튼이 막대 + 활성버튼 와이드로 표시됩니다.)
//입력값: text        (페이징 버튼에 막대 + 텍스트가 표시됩니다.)
//입력값: timer       (페이징 버튼에 막대 + 타이머가 표시됩니다.)
//입력값: text+timer  (페이징 버튼에 막대 + 텍스트 + 타이머가 표시됩니다.)
//입력값: fraction    (페이징 버튼 없이 숫자 분수 1/5 형태로 표시됩니다.)
//입력값: off         (페이징 버튼을 표시하지 않습니다.)
DF['set-mainslider-pager'] = "timer";

//배너 대기시간
//입력예: 100 = 0.1초, 1000 = 1초
DF['set-mainslider-pause'] = "4500";

//배너 전환시간
//입력예: 100 = 0.1초, 1000 = 1초
DF['set-mainslider-speed'] = "400";




/**********************************************************************************************************

	6.멀티배너 레이아웃 설정하기

	※본 기능은 모바일 디자인에서만 지원되는 기능입니다※

**********************************************************************************************************/




/**********************************************************************************************************

	7.멀티 슬라이드 배너(타이틀+안내글)

	- 멀티 슬라이드 배너의 타이틀 표시여부 및 표시내용을 설정합니다.

**********************************************************************************************************/

//타이틀 표시여부
DF['use-mtslide'] = "on";

//타이틀 표시문구
DF['rep-mtslide-tit'] = "이곳에 타이틀을 입력하세요";

//안내글 표시문구
DF['rep-mtslide-inf'] = "이곳에는 안내문구를 입력하세요";




/**********************************************************************************************************

	8.상품목록 관련 설정

	- 상품목록 페이지에 관련된 다양한 기능을 설정하실 수 있습니다.
	- 각 항목의 설명을 참고하여 설정해주세요.

**********************************************************************************************************/

//상품목록 테두리박스 표시여부
//입력값: off  (효과를 사용하지 않습니다.)
//입력값: on   (상품목록에 회색 테두리가 표시됩니다.)
DF['set-prl-imgbox'] = "off";


//상품목록 롤오버 기능 사용여부
//입력값: off  (효과를 사용하지 않습니다.)
//입력값: on   (상품목록에 마우스를 올리면 작은목록 이미지가 보여집니다.)
//입력값: zoom (상품목록에 마우스를 올리면 이미지가 확대됩니다.)
DF['set-prlrollover'] = "off";


//상품정보 좌우정렬
//입력값: left   (상품정보가 좌측으로 정렬됩니다.)
//입력값: center (상품정보가 중앙으로 정렬됩니다.)
//입력값: right  (상품정보가 우측으로 정렬됩니다.)
DF['set-prl-array'] = "left";


//컬러칩 모양 설정하기
//입력값: box    (컬러칩이 정사각형으로 표시됩니다.)
//입력값: stick  (컬러칩이 직사각형으로 표시됩니다.)
//입력값: circle (컬러칩이 둥근모양으로 표시됩니다.)
DF['set-prl-color'] = "box";


//상품정보영역 자르기
//상품정보가 길어 영역을 초과하면 잘라서 한줄로 표시합니다.
DF['set-prl-cut'] = "off";


//상품명 라인 표시여부
//상품목록의 상품명 아래의 라인 표시여부를 설정합니다.
DF['set-prl-border'] = "on";


//가격 한줄 표시여부
//상품목록의 판매가·소비자가·할인판매가의 한줄 표시여부를 설정합니다.
DF['set-prl-line'] = "on";


//새창보기 아이콘 표시여부
//상품목록의 버튼 클릭시 상품을 새창으로 볼 수 있는 기능입니다.
DF['set-prl-blank'] = "on";




/**********************************************************************************************************

	9.상품상세 관련 설정

	- 상품상세 페이지에 관련된 다양한 기능을 설정하실 수 있습니다.
	- 각 항목의 설명을 참고하여 설정해주세요.

**********************************************************************************************************/

//추천메일 버튼 표시여부
//추천메일 보내기 버튼의 표시여부를 성정합니다.
DF['use-prd-email'] = "on";


//상세설명 좌우정렬 (left 또는 center 값입력)
//상세설명의 정렬을 변경합니다. 상품등록시 강제로 정렬한 경우 미반영 됩니다.
DF['set-prd-align'] = "center";


//상세페이지 하단 구매가이드 표시여부
//상세페이지 하단에 공통으로 표시되는 결제·배송·반품 가이드입니다.
DF['use-prd-guide'] = "on";


//상세페이지 하단 후기게시판 표시여부
DF['use-prd-review'] = "on";


//상세페이지 하단 문의게시판 표시여부
DF['use-prd-qna'] = "on";


//상세페이지 구매버튼 고정기능 사용여부
DF['set-prd-optfix'] = "on";


//관련상품 함께 구매기능 사용여부
//입력값: on  (관련상품을 함께 구매할 수 있습니다.)
//입력값: off (관련상품을 함께 구매할 수 없습니다.)
DF['set-prd-related'] = "on";


//관련상품 가로 표시개수
//입력값: 2 ~ 5 사이의 숫자값을 입력하세요.
DF['set-prd-related-grid'] = "4";




/**********************************************************************************************************

	10.기타 기능 설정

	- 디자인에 포함된 기타 다양한 기능을 설정하실 수 있습니다.
	- 아래 각 항목을 참고하여 설정해주세요.

**********************************************************************************************************/

//최근 공지사항 표시여부
//메인화면에 최근 등록된 공지를 보여주는 기능입니다.
DF['use-latest'] = "on";


//메인분류 네비게이션 표시여부
//메인화면에 스크롤 시 메인분류 위치를 표시하는 기능입니다.
DF['set-movelist'] = "on";


//메인분류 네비게이션 표시방향
//입력값: y  (화면의 왼쪽에 세로로 표시됩니다.)
//입력값: x  (화면의 아래에서 가로로 표시됩니다.)
DF['set-movelist-axis'] = "y";


//메인상품 분류별 배너 시작점 설정
//입력값: before (등록한 배너가 각 메인분류 위에 순차적으로 표시됩니다.)
//입력값: after  (등록한 배너가 각 메인분류 아래에 순차적으로 표시됩니다.)
//입력값: middle (등록한 배너가 각 메인분류 타이틀 아래에 순차적으로 표시됩니다.)
DF['set-divbanner-position'] = "after";


//할인율 라벨 표시여부
//입력값: off (할인율 표시기능을 사용하지 않습니다.)
//입력값: on  (상품목록에 마우스 오버시 표시합니다.)
//입력값: fix (상품목록에 항상 할인율을 표시합니다.)
DF['set-discountrate'] = "off";


//전체메뉴보기 버튼 표시여부
DF['set-allmenu'] = "on";


//전체메뉴보기 가로 표시개수 (4~8까지 입력가능)
DF['set-allmenu-cols'] = "5";


//멀티팝업 상단 표시위치
//입력값: 0~500 까지의 값을 입력하세요
DF['set-multipopup-top'] = "270";


//멀티팝업 왼쪽 표시위치
//입력값: 0~500 까지의 값을 입력하세요
DF['set-multipopup-left'] = "150";


//갤러리 게시판 썸네일 이미지 본문 표시여부
//갤러리 게시판에서 썸네일(파일첨부 방식)의 본문에서 표시여부를 설정합니다.
//on 으로 설정하면 본문에 첨부파일 이미지가 중복으로 표시될 수 있기 때문에 off 를 권장합니다.
DF['use-gallery-fileimg'] = "off";




/**********************************************************************************************************

	11.타임세일 효과설정

    기간할인 상품에 카운트 효과를 표시하는 기능입니다. 반드시 설명을 꼼꼼히 읽어본 후 설정하세요.

	[분류번호란?]
    메인화면 아래 표시되는 상품분류는 위에서 부터 m1, m2, m3 으로 구분합니다.
	즉, 메인화면 아래 첫번째로 보이는 분류는 m1이며, 두번째로 보이는 분류는 m2 입니다.
	분류(카테고리)는 상품분류 접속후 URL(인터넷주소창) 가장 뒤에 표시되는 숫자 입니다.
	여러 분류에 적용 할때는 콤마,로 구분하여 원하는 분류에 타임세일을 적용할 수 있습니다.

	[입력예시]
	- 분류번호를 "m1" 으로 입력하면 메인화면 아래 첫번째 분류에 적용됩니다.
	- 분류번호를 "50" 으로 입력한 경우 50번 상품분류에 적용됩니다.
	- 분류번호를 "m1,50" 으로 입력한 경우 메인화면 아래 첫번째 분류와 50번 상품분류에 적용됩니다.
	- 분류번호를 "all"로 입력한 경우 모든 분류에 타임세일 효과가 적용됩니다.
	- 먼저 관리자 '프로모션 > 고객혜택관리 > 혜택등록'의 기간할인을 진행해주셔야만 작동됩니다.
	- 카운트 효과는 상품목록에서만 표시되며 상품상세에는 적용할 수 없습니다.

**********************************************************************************************************/

//타임세일 적용할 분류번호
//입력값: off     (타임세일 효과를 사용하지 않습니다.)
//입력값: all     (모든 상품에 타임세일 효과를 적용합니다.)
//입력값: 분류번호 (위 설명을 참고해 적용할 분류번호를 입력하세요.)
DF['set-timesale-cate'] = "off";

//타임세일 종료메세지 표시여부
//입력값: on     (할인 종료 및 할인이 되지 않는 상품에 종료 메세지를 표시합니다.)
//입력값: off    (할인 종료 및 할인이 되지 않는 상품에 메세지를 표시하지 않습니다.)
DF['set-timesale-after'] = "on";




/**********************************************************************************************************

	12.네이버톡톡·카카오톡 버튼

	- 해당버튼의 표시여부를 on 또는 off 로 설정하세요.
	- 링크주소는 사용중인 네이버톡톡·카카오톡(상담톡 및 플러스친구)의 URL을 입력하세요.
	- 아래의 설정항목에 따라 수정해주세요.

**********************************************************************************************************/

//네이버톡톡 픽스배너(또는 우측하단) 표시여부
DF['use-navertalk-p'] = "off";

//네이버톡톡 버튼 상품상세 표시여부
DF['use-navertalk'] = "off";

//네이버톡톡 링크주소를 입력하세요.
DF['rep-navertalk-url'] = "https://talk.naver.com/WCBXXN";


//카카오톡 픽스배너(또는 우측하단) 표시여부
DF['use-yellowid-p'] = "off";

//카카오톡 버튼 상품상세 표시여부
DF['use-yellowid'] = "off";

//카카오톡 상품상세 표기문구
DF['rep-yellowid-txt'] = "@다바걸";

//카카오톡 링크주소를 입력하세요.
DF['rep-yellowid-url'] = "https://api.happytalk.io/api/kakao/chat_open?yid=%40dabagirl&site_id=1000217748&category_id=75111&division_id=75112";




/**********************************************************************************************************

	13.SNS 아이콘

	- 아래에서 표시하고자 하는 서비스를 on 또는 off 로 설정하세요.
	- 아래에서 링크항목의 쌍따옴표("") 안의 주소를 실제 사용되는 주소로 변경하세요.

**********************************************************************************************************/

//페이스북 아이콘 표시여부
DF['use-facebook'] = "on";
//페이스북 주소
DF['put-facebook-href'] = "https://facebook.com/dnbdabagirl";


//트위터 아이콘 표시여부
DF['use-twitter'] = "off";
//트위터 주소
DF['put-twitter-href'] = "https://twitter.com/";


//인스타그램 아이콘 표시여부
DF['use-instagram'] = "on";
//인스타그램 주소
DF['put-instagram-href'] = "https://instagram.com/dabagirl_kr";


//블로그 아이콘 표시여부
DF['use-blog'] = "off";
//블로그 주소
DF['put-blog-href'] = "https://blog.naver.com/";


//카페 아이콘 표시여부
DF['use-cafe'] = "off";
//카페 주소
DF['put-cafe-href'] = "https://cafe.naver.com/";


//스마트스토어 아이콘 표시여부
DF['use-store'] = "off";
//스마트스토어 주소
DF['put-store-href'] = "https://smartstore.naver.com/";


//카카오스토리·채널 아이콘 표시여부
DF['use-kakao'] = "off";
//카카오스토리 주소
DF['put-kakao-href'] = "https://story.kakao.com/";


//웨이보 아이콘 표시여부
DF['use-weibo'] = "off";
//웨이보 주소
DF['put-weibo-href'] = "https://weibo.com/";


//QQ 아이콘 표시여부
DF['use-qq'] = "off";
//QQ 주소
DF['rep-qq-url'] = "http://www.qq.com/";


//핀터레스트 아이콘 표시여부
DF['use-pinterest'] = "off";
//핀터레스트 주소
DF['put-pinterest-href'] = "https://pinterest.com/";


//텀블러 아이콘 표시여부
DF['use-tumblr'] = "off";
//텀블러 링크
DF['put-tumblr-href'] = "https://www.tumblr.com/";


//유튜브 아이콘 표시여부
DF['use-youtube'] = "off";
//유튜브 주소
DF['put-youtube-href'] = "https://youtube.com/";


//[추가] 앱 아이콘 표시여부
DF['use-app'] = "on";
//텀블러 링크
DF['put-app-href'] = "/board/gallery/read.html?no=2379440&board_no=12";


//[추가] 출석체크 아이콘 표시여부
DF['use-check'] = "on";
//유튜브 주소
DF['put-check-href'] = "/attend/stamp.html";




/**********************************************************************************************************

	14.포토리뷰 설정하기

	- 아래에 표시된 항목의 설정에 따라 포토리뷰의 다양한 기능을 설정할 수 있습니다.
	- 아래 각 항목의 입력값을 참고하여 설정해주시기 바랍니다.

**********************************************************************************************************/

//메인화면 표시여부
DF['set-review-mainuse'] = "off";


//메인화면 타입보기 버튼 표시여부
DF['set-review-maintypebtn'] = "off";


//메인화면 출력타입
//입력값: list    (게시물이 리스트 형태로 표시됩니다.)
//입력값: gallery (게시물이 갤러리 형태로 표시됩니다.)
DF['set-review-maintype'] = "gallery";


//메인화면 가로개수
//목록 타입이 갤러리(gallery)일 때만 반영됩니다.
DF['set-review-maingallerycols'] = "5";


//상품상세 타입보기 버튼 표시여부
DF['set-review-detailtypebtn'] = "off";


//상품상세 출력타입
//입력값: list (게시물이 리스트 형태로 표시됩니다.)
//입력값: gallery (게시물이 갤러리 형태로 표시됩니다.)
DF['set-review-detailtype'] = "list";


//상품상세 하단 가로개수
//목록 타입이 갤러리(gallery)일 때만 반영됩니다.
DF['set-review-detailgallerycols'] = "5";


//게시판 전용 타입보기 버튼 표시여부
DF['set-review-listtypebtn'] = "off";


//게시판 전용 화면 출력타입
//입력값: list    (게시물이 리스트 형태로 표시됩니다.)
//입력값: gallery (게시물이 갤러리 형태로 표시됩니다.)
DF['set-review-listtype'] = "list";


//게시판 전용 화면 가로개수
//목록 타입이 갤러리(gallery)일 때만 반영됩니다.
DF['set-review-listgallerycols'] = "5";




/**********************************************************************************************************

	15.상품목록 더보기 버튼 설정하기

	- 더보기 버튼은 메인화면의 메인분류에서만 사용 가능합니다.

**********************************************************************************************************/

//메인분류 더보기 버튼 표시여부
//상품목록에 슬라이드 효과를 적용한 분류는 더보기가 표시되지 않습니다.
DF['use-prl-more'] = "on";


//페이지카운트 표시
//더보기 버튼에서 현재 페이지와 남은 페이지의 표시여부를 설정합니다.
DF['use-prl-more-page'] = "off";


//메인분류 더보기 캐시기능[매뉴얼 참조]
//더보기를 클릭하거나 터치한 경우 재접속시 이전 상태를 기억합니다




/**********************************************************************************************************

	16.상품목록 타입보기 버튼 설정하기

	- 상품목록에 타입보기 버튼종류 및 버튼전체 표시여부를 설정합니다.
	- 상품목록에 슬라이드가 적용된 분류는 타입보기버튼이 표시되지 않습니다.

**********************************************************************************************************/

//표시될 버튼의 입력값을 입력하세요. 한개 이상은 콤마(,)로 구분하여 입력하세요.
//입력값:	fade   (페이드효과 버튼)
//입력값:	grid1  (1단보기 버튼)
//입력값:	grid2  (2단보기 버튼)
//입력값:	grid3  (3단보기 버튼)
//입력값:	grid4  (4단보기 버튼)
//입력값:	grid5  (5단보기 버튼)
//입력값:	note   (노트타입 버튼)
DF['set-productlist-btn'] = "fade, grid3, grid4, note";

//메인 1번째 분류 표시여부
DF['set-prlmain-btn'][1] = "off";

//메인 2번째 분류 표시여부
DF['set-prlmain-btn'][2] = "off";

//메인 3번째 분류 표시여부
DF['set-prlmain-btn'][3] = "off";

//메인 4번째 분류 표시여부
DF['set-prlmain-btn'][4] = "off";

//메인 5번째 분류 표시여부
DF['set-prlmain-btn'][5] = "off";

//메인 6번째 분류 표시여부
DF['set-prlmain-btn'][6] = "off";

//메인 7번째 분류 표시여부
DF['set-prlmain-btn'][7] = "off";

//일반 상품목록 표시여부
DF['set-prlnorm-btn'][1] = "on";

//검색 상품목록 표시여부
DF['set-prlsrch-btn'][1] = "off";

//기획전 상품목록 표시여부
DF['set-prlproj-btn'][1] = "off";




/**********************************************************************************************************

	17.상품목록 가로 개수·노트타입 설정하기

	- 상품목록에 기본으로 표시되는 가로개수 또는 노트타입을 설정합니다.
	- 아래 적용할 분류의 쌍따옴표 안에 입력값을 입력하세요.

	[입력값 설명]
	grid1  :상품목록이 가로 1개로 표시됩니다.
	grid2  :상품목록이 가로 2개로 표시됩니다.
	grid3  :상품목록이 가로 3개로 표시됩니다.
	grid4  :상품목록이 가로 4개로 표시됩니다.
	grid5  :상품목록이 가로 5개로 표시됩니다.
	note   :노트타입으로 PC에서는 가로 2개 모바일 디자인은 가로 1개로 표시됩니다.

**********************************************************************************************************/

//메인 1번째 분류 가로개수
DF['set-prlmain-grid'][1] = "grid4";

//메인 2번째 분류 가로개수
DF['set-prlmain-grid'][2] = "grid4";

//메인 3번째 분류 가로개수
DF['set-prlmain-grid'][3] = "grid4";

//메인 4번째 분류 가로개수
DF['set-prlmain-grid'][4] = "grid4";

//메인 5번째 분류 가로개수
DF['set-prlmain-grid'][5] = "grid4";

//메인 6번째 분류 가로개수
DF['set-prlmain-grid'][6] = "grid4";

//메인 7번째 분류 가로개수
DF['set-prlmain-grid'][7] = "grid4";

//추천 상품목록 가로개수
DF['set-prlrcmd-grid'][1] = "grid4";

//일반 상품목록 가로개수
DF['set-prlnorm-grid'][1] = "grid4";

//검색 상품목록 가로개수
DF['set-prlsrch-grid'][1] = "grid4";

//기획전 목록 가로개수
DF['set-prlproj-grid'][1] = "grid4";




/**********************************************************************************************************

	18.상품목록 기본·슬라이드 설정하기

	- 상품목록을 기본 또는 슬라이드로 표시할 수 있습니다.
	- 아래 적용할 분류의 쌍따옴표 안의 값을 입력값으로 수정해주세요.
	- 슬라이드인 경우 해당분류에 타입보기·더보기버튼이 표시되지 않습니다.

	[입력값 설명]
	list   :상품목록이 일반형태로 표시됩니다.
	slide  :상품목록이 1줄 슬라이드로 표시됩니다.
	slide2 :상품목록이 2줄 슬라이드로 표시됩니다.

**********************************************************************************************************/

//메인 1번째 분류 리스트타입
DF['set-prlmain-type'][1] = "list";

//메인 2번째 분류 리스트타입
DF['set-prlmain-type'][2] = "list";

//메인 3번째 분류 리스트타입
DF['set-prlmain-type'][3] = "list";

//메인 4번째 분류 리스트타입
DF['set-prlmain-type'][4] = "list";

//메인 5번째 분류 리스트타입
DF['set-prlmain-type'][5] = "list";

//메인 6번째 분류 리스트타입
DF['set-prlmain-type'][6] = "list";

//메인 7번째 분류 리스트타입
DF['set-prlmain-type'][7] = "list";

//추천 상품목록 리스트타입
DF['set-prlrcmd-type'][1] = "list";

//일반 상품목록 리스트타입
DF['set-prlnorm-type'][1] = "list";

//검색 상품목록 리스트타입
DF['set-prlsrch-type'][1] = "list";

//기획전 상품목록 리스트타입
DF['set-prlproj-type'][1] = "list";




/**********************************************************************************************************

	19.상품목록 기본·페이드 표시방식 설정하기

	- 상품목록 이미지를 기본 또는 페이드 타입으로 표시할 수 있습니다.
	- 아래 적용할 분류의 쌍따옴표 안의 값을 입력값으로 수정해주세요.

	[입력값 설명]
	normal  :상품명·가격 등의 성품정보가 기본형태로 표시됩니다.
	fade    :상품명·가격 등의 정보가 상품에 마우스를 올렸을 때 표시됩니다.

**********************************************************************************************************/

//메인 1번째 분류 뷰타입
DF['set-prlmain-view'][1] = "normal";

//메인 2번째 분류 뷰타입
DF['set-prlmain-view'][2] = "normal";

//메인 3번째 분류 뷰타입
DF['set-prlmain-view'][3] = "normal";

//메인 4번째 분류 뷰타입
DF['set-prlmain-view'][4] = "normal";

//메인 5번째 분류 뷰타입
DF['set-prlmain-view'][5] = "normal";

//메인 6번째 분류 뷰타입
DF['set-prlmain-view'][6] = "normal";

//메인 7번째 분류 뷰타입
DF['set-prlmain-view'][7] = "normal";

//추천 상품목록 뷰타입
DF['set-prlrcmd-view'][1] = "normal";

//일반 상품목록 뷰타입
DF['set-prlnorm-view'][1] = "normal";

//검색 상품목록 뷰타입
DF['set-prlsrch-view'][1] = "normal";

//기획전 상품목록 뷰타입
DF['set-prlproj-view'][1] = "normal";




/**********************************************************************************************************

	20.메인·상품분류 상품표시 개수 설정하기※

	- 메인분류와 상품분류(카테고리)에 한페이지당 표시될 상품개수를 설정합니다.
	- 본 설정은 카페24 변수를 이용하므로 디자인매뉴얼을 참고하여 설정해주세요.

	[매뉴얼 위치]
	디자인플로어 접속 '로그인 > 디자인매뉴얼 > 구매한 디자인매뉴얼 > 상품표시개수'를 참고 바랍니다.

**********************************************************************************************************/











/**********************************************************************************************************

	추가 설정

**********************************************************************************************************/

/* 메인 탭슬라이드 타이틀 설정 */
DF['rep-tabslide-tit'] = 'WEEKLY BEST';

/* 메인 탭슬라이드 설명글 설정 */
DF['rep-tabslide-inf'] = '한주동안 사랑받은 베스트 아이템';

/* 상세페이지 무이자 할부 안내 사용여부 */
DF['use-installment'] = 'on';



/* 메인슬라이드, 배너 타임세일 기능 */
DF['set-tsbncate-no'] = [];
DF['set-tsbncate-time'] = [];

// 카테고리 상단배너 타임세일 설정1 (카테고리 넘버 입력)
DF['set-tsbncate-no'][1] = '';
// 카테고리 상단배너 타임세일 설정1 (마감시간 입력 ex> 2023-11-26 00:00:00 형식)
DF['set-tsbncate-time'][1] = '2023-11-09 06:09:00';

// 카테고리 상단배너 타임세일 설정2 (카테고리 넘버 입력)
DF['set-tsbncate-no'][2] = '';
// 카테고리 상단배너 타임세일 설정2 (마감시간 입력 ex> 2023-11-26 00:00:00 형식)
DF['set-tsbncate-time'][2] = '2023-12-22 03:23:00';

// 카테고리 상단배너 타임세일 설정3 (카테고리 넘버 입력)
DF['set-tsbncate-no'][3] = '';
// 카테고리 상단배너 타임세일 설정3 (마감시간 입력 ex> 2023-11-26 00:00:00 형식)
DF['set-tsbncate-time'][3] = '';







/**
	======================================================================================================

        D E S I G N F L O O R

		이 쇼핑몰은 디자인플로어 서비스를 이용하고 있습니다.

        [대표전화] 1544-4941
        [홈페이지] www.dfloor.co.kr
        [특허청출원번호] 4120150030498

        디자인의 모든 저작권은 디자인플로어에 있으며, 1Copy 라이선스로 최초 적용된 쇼핑몰에서만 사용권을
        부여합니다. 디자인플로어 콘텐츠의 모든 라이선스는 아래의 '법적 고지'를 따릅니다.

	======================================================================================================

		※디자인플로어 라이선스 법적 고지※

		-본 사이트에 존재하는 모든 기술적 소스코드의 저작권은 오직 디자인플로어에 있습니다.
		-본 사이트에 존재하는 기술적 소스코드를 사용할 경우와 이를 변형하여 활용하는 경우
		 저작권법에 의거 법적 고지를 위반하는 것으로 판단하며 즉각 민형사상의 조치를 취합니다.
		-디자인플로어는 디자인의 개발·생산 및 콘텐츠의 보호를 가장 우선으로 하므로 진행되는
		 민형사소송건에 대한 합의는 진행하지 않는 점을 고지합니다.
		-디자인플로어는 민가율 합동 법률사무소 '김석호 변호사'와 함께 지적재산권을 수호하며
		 자문을 받고 있습니다.

	======================================================================================================
**/
/**
	업데이트: 2020-09-10
**/


// 문자열 파라미터 배열로 가져오기 2016-11-22
function df_getParam(str){
	if(!str || typeof str!=='string') return false;
	var param = new Array();
	var params;
	params = str.substring(str.indexOf('?')+1, str.length );
	params = params.split("&");
	var size = params.length;
	var key, value;
	for(var i=0; i<size; i++){
		key = params[i].split("=")[0];
		value = params[i].split("=")[1];
		param[key] = value;
	}
	return param;
}


// 배열 파라미터 문자열로 가져오기 2016-11-22
function df_getString(obj){
	if(!obj || typeof obj!=='object') return false;
	return $DF.param(obj);
}


// 배열, 문자열 파라미터 지정 값만 가져오기 2016-11-22
function df_getValue(data, name){
	var type = typeof data;
	if(type!=='string' && type!=='object' || !name) return false;
	if(type==='string')	data = df_getParam(data);
	return data[name];
}


// 이미지 로드 체크 2020-09-10
function df_loadElements(selector, elements, callback){
	var $el = selector.find(elements);
	var total = $el.length;
	if (total == 0){
		callback($el);
		return;
	}
	var count = 0;
	$el.each(function(){
		$DF(this).one('load', function() {
			if(++count == total) callback($el);
		}).each(function() {
			if(this.complete) $DF(this).trigger('load');
		});
	});
}


// 현재 페이지 카테고리 넘버 가져오기 2020-11-16
function df_getCateNo(str){
	var cateno = df_getParam(str)['cate_no'];
	if(cateno==undefined){
		var url = window.location.pathname.split('/');
		if(url[1]=='category')
			cateno = url[3];
	}
	return cateno;
}
(function($){
if($(location).attr('host').indexOf('ecudemo119600.cafe24.com')>=0){


	//세팅전 HTML 코드 넣기
	$(document).ready(function(){


		function inputImg(src){
			var imgarea = $('.tit-product, .xans-board-title').find('.img, .imgArea');
			imgarea.append('<img src="'+src+'">');
		}

		var arr = df_getParam($(location).attr('search'));
		if(arr['cate_no']){
			var cate_no = arr['cate_no'];
		}else if(arr['board_no']){
			var board_no = arr['board_no'];
		}


		//상품분류 상단이미지
		if(cate_no==703){
			inputImg('/web/upload/dfloor_base/sample/images/pc_top_category_1280.jpg');
		}else if(cate_no==704){
			inputImg('/web/upload/dfloor_base/sample/images/pc_top_category_1280.jpg');
		}else if(cate_no==705){
			inputImg('/web/upload/dfloor_base/sample/images/pc_top_category_1280.jpg');
		}else if(cate_no==706){
			inputImg('/web/upload/dfloor_base/sample/images/pc_top_category_1280.jpg');
		}else if(cate_no==707){
			inputImg('/web/upload/dfloor_base/sample/images/pc_top_category_1280.jpg');
		}else if(cate_no==708){
			inputImg('/web/upload/dfloor_base/sample/images/pc_top_category_1280.jpg');
		}else if(cate_no==709){
			inputImg('/web/upload/dfloor_base/sample/images/pc_top_category_1280.jpg');
		}

		/* 브랜드목록 */
		else if(cate_no==702){
			inputImg('/web/upload/dfloor_base/sample/images/pc_top_brand_1280.jpg');
		}

		/* 타임세일 */
		else if(cate_no==712){
			inputImg('/web/upload/dfloor_base/sample/images/pc_divbanner_timesale_1280.jpg');
		}


		//게시판 상단이미지
		if(board_no==1){
			inputImg('/web/upload/dfloor_base/sample/images/pc_top_board_1280.jpg');
		}else if(board_no==4){
			inputImg('/web/upload/dfloor_base/sample/images/pc_top_board_1280.jpg');
		}else if(board_no==6){
			inputImg('/web/upload/dfloor_base/sample/images/pc_top_board_1280.jpg');
		}else if(board_no==8){
			inputImg('/web/upload/dfloor_base/sample/images/pc_top_board_1280.jpg');
		}


		//브랜드 게시판
		if($(location).attr('pathname')=='/page/brand.html'){
			inputImg('/web/upload/dfloor_base/web/sample/top_img_brand_1280.jpg');
		}


		//상세페이지 네이버페이
		$("#df-product-detail .btn-outside-service").append('<div style="text-align:right"><img src="/web/upload/dfloor_base/web/sample/detail_naverpay.jpg"></div>');


		//기타 페이지 추가요소
		//$(".class-name").append('<img src="url">');


		//첫번째 분류 회사소개 페이지로 이동
		$("a[href$='701']").attr("href","/shopinfo/company.html");


	});

	//말풍선 아이콘 표시여부
	DF['use-msgbox'] = "on";

	//첫번째줄 표시문구
	DF['rep-returnex-txt1'] = "서울특별시 강남구 삼성동 1st Floor 디자인플로어";

	//입금계좌번호
	DF['ins-banking-li'][1] = "국민 000-000-0000";
	DF['ins-banking-li'][2] = "신한 000-000-0000";
	DF['ins-banking-li'][3] = "예금주: 디자인플로어";

	//슬라이드 표시 위치
	DF['set-mainslider-position'] = "top";

	//타이틀 표시문구 (타이틀 문구를 입력하세요.)
	DF['rep-mtslide-tit'] = "SPECIAL THINGS";

	//안내글 표시문구 (안내글 문구를 입력하세요.)
	DF['rep-mtslide-inf'] = "만듦새의 비약적 향상. 비결은 디테일의 차이";

	//상품목록 롤오버 기능 사용여부
	//입력값: off  (효과를 사용하지 않습니다.)
	//입력값: on   (상품목록에 마우스를 올리면 작은목록 이미지가 보여집니다.)
	//입력값: zoom (상품목록에 마우스를 올리면 이미지가 확대됩니다.)
	DF['set-prlrollover'] = "on";

	//적용상품 분류번호
	DF['set-timesale-cate'] = "m3,712";

	//네이버톡톡 버튼 우측픽스 표시여부
	DF['use-navertalk-p'] = "on";

	//네이버톡톡 버튼 상세페이지 표시여부
	DF['use-navertalk'] = "off";

	//카카오톡 버튼 우측픽스 표시여부
	DF['use-yellowid-p'] = "on";

	//카카오톡 버튼 상세페이지 표시여부
	DF['use-yellowid'] = "off";

}
})($DF);
/*
* rwdImageMaps jQuery plugin v1.6
*
* Allows image maps to be used in a responsive design by recalculating the area coordinates to match the actual image size on load and window.resize
*
* Copyright (c) 2016 Matt Stow
* https://github.com/stowball/jQuery-rwdImageMaps
* http://mattstow.com
* Licensed under the MIT license


마지막 업데이트 : 2021-08-20 by df custom
*/

!function(o){o.fn.rwdImageMaps=function(){var t=this;return o(window).resize(function(){t.each(function(){var r;void 0!==o(this).attr("usemap")&&(r=o(this),o("<img />").on("load",function(){var e=r.attr("width"),i=r.attr("height");e&&i||((a=new Image).src=r.attr("src"),e=e||a.width,i=i||a.height);var h=r.width()/100,s=r.height()/100,t=r.attr("usemap").replace("#",""),c="coords",a=o('map[name="'+t+'"]');a.length||(a=o('map[name="#'+t+'"]')),e&&i||(e=e||r[0].naturalWidth,i=i||r[0].naturalHeight),a.find("area").each(function(){var t=o(this);t.data(c)||t.data(c,t.attr(c));for(var a=t.data(c).split(","),r=new Array(a.length),n=0;n<r.length;++n)r[n]=n%2==0?parseInt(a[n]/e*100*h):parseInt(a[n]/i*100*s);t.attr(c,r.toString())})}).attr("src",r.attr("src")))})}).trigger("resize"),this}}($DF);
/**
	======================================================================================================

        D E S I G N F L O O R

		이 쇼핑몰은 디자인플로어 서비스를 이용하고 있습니다.

        [대표전화] 1544-4941
        [홈페이지] www.dfloor.co.kr
        [특허청출원번호] 4120150030498

        디자인의 모든 저작권은 디자인플로어에 있으며, 1Copy 라이선스로 최초 적용된 쇼핑몰에서만 사용권을
        부여합니다. 디자인플로어 콘텐츠의 모든 라이선스는 아래의 '법적 고지'를 따릅니다.

	======================================================================================================

		※디자인플로어 라이선스 법적 고지※

		-본 사이트에 존재하는 모든 기술적 소스코드의 저작권은 오직 디자인플로어에 있습니다.
		-본 사이트에 존재하는 기술적 소스코드를 사용할 경우와 이를 변형하여 활용하는 경우
		 저작권법에 의거 법적 고지를 위반하는 것으로 판단하며 즉각 민형사상의 조치를 취합니다.
		-디자인플로어는 디자인의 개발·생산 및 콘텐츠의 보호를 가장 우선으로 하므로 진행되는
		 민형사소송건에 대한 합의는 진행하지 않는 점을 고지합니다.
		-디자인플로어는 민가율 합동 법률사무소 '김석호 변호사'와 함께 지적재산권을 수호하며
		 자문을 받고 있습니다.

	======================================================================================================
**/
/**
	PC디자인 전용
	업데이트: 2022-11-24
	-특정상황 충돌예방 var plugin = this; → var plugin = {}; 2021-09-23
	-중분류 없이 분류 팝업배너만 사용중이면 df-cnb-popupbanner_only 클래스 추가 2022-11-24
	-중분류의 표시 방식을 css제어로 변경하기 위해 기존 fadeIn, fadtOut 관련 소스를 제거함 2022-11-24
**/


!function(){var n=[],d=[],r=[],o=[],f=[],h=!1,u=$DF(".df-popupbanner-storage-item");$DF.dfcategory=function(e,a){var c,l={responsive:!0,maxDepth:4,selectedUse:!1,selectedClass:"df-cnb-item_active",depth:{},initBefore:function(){return!0},initAfter:function(){return!0}},p={},s=$DF(e);p.init=function(){if(c=p.settings=$DF.extend({},l,a),"undefined"!=typeof setSize){c.initBefore.call(p,s),c.depth[0]={};for(var e=1;e<=c.maxDepth;e++){var d=e;null==c.depth[d]&&(c.depth[d]={}),s.find(".df-cnb-m"+d).find(".df-cnb-item_d"+d).each(function(){var e,n=$DF(this),t=n.attr("df-cate-no");thistext=n.text(),null!=o[t]&&c.maxDepth>d&&((0<c.depth[d].childMark.length?n.append(o[t].join("")).find("div").addClass("df-cnb-m"+(d+1)).siblings("a").append(c.depth[d].childMark).siblings("div"):n.append(o[t].join("")).find("div").addClass("df-cnb-m"+(d+1))).find("li").addClass("df-cnb-item_d"+(d+1)),1==d&&(e=parseInt((parseInt(n.width())-parseInt(n.children("div").width()))/2),n.children("div").css({"margin-left":e+"px"}))),1!=c.depth[d].childPopupImg||!h||0<=(t=$DF.inArray(encodeURI(thistext),f))&&(e=parseInt((parseInt(n.width())-parseInt(n.children("div").width()))/2),(0<n.children("div").length?n.children("div").append('<div class="df-cnb-popupbanner">'+u.eq(t)[0].innerHTML+"</div>").addClass("df-cnb-m"+(d+1)).css({"margin-left":e+"px"}):n.append('<div class="df-cnb-popupbanner_only"><div class="df-cnb-popupbanner">'+u.eq(t)[0].innerHTML+"</div></div>").children("div").addClass("df-cnb-m"+(d+1))).find(".df-cnb-popupbanner a").attr("href",function(){return""==$DF(this).attr("href")?"#none":$DF(this).attr("href")})),n.attr("df-cate-depth",d)})}if(c.selectedUse){var n,t=parseInt(df_getValue(window.location.href,"cate_no"));if(t||(n=window.location.pathname.split("/"),t=(t=parseInt(n[n.indexOf("category")+1]))||parseInt(n[n.indexOf("category")+2])),t&&null!=r[t]){s.find('[df-cate-no="'+t+'"]').addClass(c.selectedClass);for(var i=r[t].parent_cate_no;null!=r[i];)s.find('[df-cate-no="'+i+'"]').addClass(c.selectedClass),i=r[i].parent_cate_no}}s.find("li").on({mouseenter:function(){var e=$DF(this),n=parseInt(e.attr("df-cate-depth"));n&&c.depth[n].childType,e.addClass("df-cnb-item_on")},mouseleave:function(){var e=$DF(this),n=parseInt(e.attr("df-cate-depth"));n&&c.depth[n].childType,e.removeClass("df-cnb-item_on")}}),c.initAfter.call(p,s)}},p.init()},$DF.fn.dfcategory=function(t){return this.each(function(){if("undefined"!=typeof setSize){var e=$DF(this),n=e.data("dfcategory");return n?n.methods[t]?n.methods[t].apply(this,Array.prototype.slice.call(arguments,1)):void 0:(n=new $DF.dfcategory(this,t),e.data("dfcategory",n),n)}})},"on"==DF["set-allmenu"]&&(n["df-lnb-allmenu"]={maxDepth:4,depth:{1:{childType:"default",childPopupSpeed:70,childPopupImg:!1,childMark:""},2:{childType:"popup",childPopupSpeed:70,childPopupImg:!1,childMark:'<i class="df-cnb-item-subicon"></i>'},3:{childType:"popup",childPopupSpeed:70,childPopupImg:!1,childMark:'<i class="df-cnb-item-subicon"></i>'}},initAfter:function(e){4<=parseInt(DF["set-allmenu-cols"])&&parseInt(DF["set-allmenu-cols"])<=8&&e.find(".df-allmenu-left").addClass("df-allmenu_grid_"+parseInt(DF["set-allmenu-cols"]))}},$DF(".df-lnb-allmenu").addClass("df-lnb-allmenu_active")),n["df-lnb-category"]={responsive:!0,maxDepth:4,selectedUse:!0,selectedClass:"df-cnb-item_active",depth:{1:{childType:"popup",childPopupSpeed:70,childPopupImg:!0,childMark:""},2:{childType:"popup",childPopupSpeed:70,childPopupImg:!1,childMark:'<i class="df-cnb-item-subicon"></i>'},3:{childType:"popup",childPopupSpeed:70,childPopupImg:!1,childMark:'<i class="df-cnb-item-subicon"></i>'}},initAfter:function(e){}},$DF(".df-lnb-category").addClass("df-lnb-category_active"),$DF.ajax({url:"/exec/front/Product/SubCategory",dataType:"json",success:function(e){if(e)for(var n=0;n<e.length;n++)r[e[n].cate_no]=e[n],d[e[n].parent_cate_no]||(d[e[n].parent_cate_no]=[]),d[e[n].parent_cate_no].push(e[n]);for(var t in d)if(0!=$DF.isNumeric(t)){o[t]=[],o[t].push('<div><ul class="df-cnb-sub-items">');for(n=0;n<d[t].length;n++)o[t].push('<li class="df-cnb-sub-item" df-cate-no="'+d[t][n].cate_no+'"><a class="df-cnb-sub-item-link" href="/'+d[t][n].design_page_url+d[t][n].param+'">'+d[t][n].name+"</a></li>");o[t].push("</ul></div>")}}}).done(function(){for(var e=0;e<u.length;e++)f[e]=encodeURI(u.eq(e).attr("df-data-id"));for(k in f.join("").length&&(h=!0),n)$DF("."+k).dfcategory(n[k])})}();

/**
	======================================================================================================

        D E S I G N F L O O R

		이 쇼핑몰은 디자인플로어 서비스를 이용하고 있습니다.

        [대표전화] 1544-4941
        [홈페이지] www.dfloor.co.kr
        [특허청출원번호] 4120150030498

        디자인의 모든 저작권은 디자인플로어에 있으며, 1Copy 라이선스로 최초 적용된 쇼핑몰에서만 사용권을
        부여합니다. 디자인플로어 콘텐츠의 모든 라이선스는 아래의 '법적 고지'를 따릅니다.

	======================================================================================================

		※디자인플로어 라이선스 법적 고지※

		-본 사이트에 존재하는 모든 기술적 소스코드의 저작권은 오직 디자인플로어에 있습니다.
		-본 사이트에 존재하는 기술적 소스코드를 사용할 경우와 이를 변형하여 활용하는 경우
		 저작권법에 의거 법적 고지를 위반하는 것으로 판단하며 즉각 민형사상의 조치를 취합니다.
		-디자인플로어는 디자인의 개발·생산 및 콘텐츠의 보호를 가장 우선으로 하므로 진행되는
		 민형사소송건에 대한 합의는 진행하지 않는 점을 고지합니다.
		-디자인플로어는 민가율 합동 법률사무소 '김석호 변호사'와 함께 지적재산권을 수호하며
		 자문을 받고 있습니다.

	======================================================================================================
**/
/**
	업데이트: 2023-08-20
**/


(function(){var a=$DF(".df-prl-items");a.length&&("undefined"!=typeof DF["set-prl-array"]&&a.addClass("df-prl-items_type_"+DF["set-prl-array"]),"undefined"!=typeof DF["set-prl-color"]&&a.addClass("df-prl-items_type_color"+DF["set-prl-color"]),"on"===DF["set-prl-border"]&&a.addClass("df-prl-items_type_border"),"on"===DF["set-prl-line"]&&a.addClass("df-prl-items_type_oneline"),"on"===DF["set-prl-imgbox"]&&a.addClass("df-prl-items_type_imgbox"),"zoom"===DF["set-prlrollover"]&&a.addClass("df-prl-items_type_zoom"),"on"===DF["set-prl-blank"]&&a.addClass("df-prl-items_type_blank"),"on"===DF["set-prl-cut"]&&a.addClass("df-prl-items_type_cut"))})(),function(){var a=$DF(".df-prl-wrap");if(a.length){var b=a.find(".df-prl-items"),c=b.find(".df-prl-box");if(c.length){var d=function(){var d={};d.init=function(){if("on"==DF["set-prlrollover"]&&d.setImageOver(),"off"!=DF["set-timesale-cate"]){var e,f=DF["set-timesale-cate"].replace(/ /gi,"").split(",");if(-1<f.indexOf("all"))e=$DF(".df-prl-timesale");else if($DF("#wrap").hasClass("df-wrap-main"))for(var g=0;g<f.length;g++)f[g].match("m")&&(e=e?e.add(a.filter(".xans-product-listmain").eq(parseInt(f[g].replace("m",""))-1).find(".df-prl-timesale")):a.filter(".xans-product-listmain").eq(parseInt(f[g].replace("m",""))-1).find(".df-prl-timesale"));else{var h=df_getCateNo(location.search);-1<f.indexOf(h)&&(e=a.filter(".xans-product-listnormal, .xans-product-listrecommend").find(".df-prl-timesale"))}e&&e.length&&d.setTimeSale(e)}d.setOptionLayer(),d.setDiscountRate(c);const j={childList:!0,subtree:!0},k=new MutationObserver(b=>{for(const f of b)if("childList"===f.type){var c=$DF(f.target);if($DF("#wrap").hasClass("df-wrap-main")&&"off"!=DF["set-timesale-cate"]){var e=DF["set-timesale-cate"].replace(/ /gi,"").split(",");(-1<e.indexOf("all")||-1<e.indexOf("m"+(a.index(c.parents(".df-prl-wrap"))+1)))&&d.setTimeSale(c.find(".df-prl-timesale"))}d.setDiscountRate(c.find(".df-prl-box"))}});for(var g=0;g<b.length;g++)k.observe(b.eq(g)[0],j)},d.setImageOver=function(){b.on("mouseenter",".df-prl-box",function(){var a=$DF(this).find(".df-prl-thumb").children("a"),b=a.attr("df-data-rolloverimg1"),c=a.attr("df-data-rolloverimg2");if(0<b.length&&0<c.length){var d=a.children(".thumb");1==d.length&&(d.clone().prependTo(a).addClass("df-prl-rollover").attr("src",c),d=a.children(".thumb")),d.eq(0).stop().fadeIn(130,"easeOutCirc"),d.eq(1).stop().animate({opacity:0},130,"easeOutCirc")}}),b.on("mouseleave",".df-prl-box",function(){var a=$DF(this),b=a.find(".thumb");1<b.length&&(b.eq(0).stop().fadeOut(130,"easeInCirc"),b.eq(1).stop().animate({opacity:1},130,"easeOutCirc")),a.find(".prdOption").hide()})},d.setOptionLayer=function(){b.on("mouseleave",".df-prl-box",function(){var a=$DF(this);a.find(".prdOption").hide()})},d.setDiscountRate=function(a){if("off"==DF["set-discountrate"])return void b.addClass("df-prl-items_type_discountrate_none");"fix"==DF["set-discountrate"]&&b.addClass("df-prl-items_type_discountrate_fix");var c=a.find(".df-prl-discountrate"),d=function(a){if(!a)return 0;var b=a.split(" ");if(void 0!==b[0]){var c=parseFloat(b[0].replace(/[^-\.0-9]/g,""));if(0<c)return c}if(void 0!==b[1]){var c=parseFloat(b[1].replace(/[^-\.0-9]/g,""));if(0<c)return c}return 0};c.each(function(){var c=$DF(this),e=c.children(".rate"),f=c.children(".df-prl-data-custom").text(),g=c.children(".df-prl-data-price").text(),h=c.children(".df-prl-data-sale").text(),i=d(f),j=d(g),k=d(h),l=0,m=0;0<i&&0<k?(l=i,m=k):0<j&&0<k?(l=j,m=k):0<i&&0<j&&(l=i,m=j),rate=Math.round(100-100*(m/l)),0<rate?e.text(rate):c.addClass("displaynone").hide()})},d.setTimeSale=function(a){var b,c=a,d=c.filter(":not([df-data-timesale-start=\"\"])"),e=d.length,f=c.filter("[df-data-timesale-start=\"\"]"),g=f.length;if(d.addClass("df-prl-timesale_active"),"on"==DF["set-timesale-after"]&&f.addClass("df-prl-timesale_active"),0<e){function a(a){return 10>a?"0"+a:a}function c(b){var c=Math.floor(b/86400000),d=a(Math.floor(b%86400000/3600000)),e=a(Math.floor(b%3600000/60000)),f=a(Math.floor(b%60000/1e3));return[c,d,e,f]}function e(){serverTime=i.getTime()+1e3,i=new Date(serverTime),d.each(function(){var a=$DF(this),b=(a.attr("df-data-timesale-start")+":00").match(/^(\d+)-(\d+)-(\d+) (\d+)\:(\d+)\:(\d+)$/),d=(a.attr("df-data-timesale-end")+":00").match(/^(\d+)-(\d+)-(\d+) (\d+)\:(\d+)\:(\d+)$/),e=new Date(b[1],b[2]-1,b[3],b[4],b[5],b[6]).getTime(),f=new Date(d[1],d[2]-1,d[3],d[4],d[5],d[6]).getTime();if(serverTime<e){var g=c(e-serverTime),h=a.find(".df-prl-timesale_before");h.children().length||h.append("<span class=\"df-prl-timesale_text1\"></span><span class=\"df-prl-timesale_no\"></span><span class=\"df-prl-timesale_text2\"></span><span class=\"df-prl-timesale_no\"></span><span class=\"df-prl-timesale_text3\"></span><span class=\"df-prl-timesale_no\"></span><span class=\"df-prl-timesale_text4\"></span><span class=\"df-prl-timesale_no\"></span><span class=\"df-prl-timesale_text5\"></span>");var i=h.children(".df-prl-timesale_no");h.show().siblings("").hide(),i.eq(0).text(g[0]),i.eq(1).text(g[1]),i.eq(2).text(g[2]),i.eq(3).text(g[3])}else if(serverTime<=f){var g=c(f-serverTime),h=a.find(".df-prl-timesale_ing");h.children().length||h.append("<span class=\"df-prl-timesale_text1\"></span><span class=\"df-prl-timesale_no\"></span><span class=\"df-prl-timesale_text2\"></span><span class=\"df-prl-timesale_no\"></span><span class=\"df-prl-timesale_text3\"></span><span class=\"df-prl-timesale_no\"></span><span class=\"df-prl-timesale_text4\"></span><span class=\"df-prl-timesale_no\"></span><span class=\"df-prl-timesale_text5\"></span>");var i=h.children(".df-prl-timesale_no");i.eq(0).text(g[0]),i.eq(1).text(g[1]),i.eq(2).text(g[2]),i.eq(3).text(g[3]),h.show().siblings("").hide(),a.parent(".df-prl-box").find(".df-prl-discountrate").addClass("show")}else a.find(".df-prl-timesale_after").show().siblings("").hide()})}if(null==document.lastModified){function a(){try{h=new XMLHttpRequest}catch(a){try{h=new ActiveXObject("Msxml2.XMLHTTP")}catch(a){try{h=new ActiveXObject("Microsoft.XMLHTTP")}catch(a){console.log("AJAX not supported")}}}return h.open("HEAD",window.location.href.toString(),!1),h.setRequestHeader("Content-Type","text/html"),h.send(""),h.getResponseHeader("Date")}var h,i=new Date(a())}else var i=new Date(document.lastModified);e(),clearInterval(b),b=setInterval(e,1e3),d.show()}"on"==DF["set-timesale-after"]&&0<g&&f.show().find(".df-prl-timesale_after").show().siblings("").hide()},d.init()};d()}}}(),function(){var a=$DF(".df-prl-wrap"),b=a.filter(".df-prl-setup");if(b.length){var c=function(a){var b={},c=a.find(".df-prl-items");if(c.length){if("prlproj"==a[0].data.code||"prlmain"==a[0].data.code){var d=a[0].data.code,e=parseInt(a[0].data.index)+1;if("undefined"==typeof DF["set-"+d+"-btn"][e]||"undefined"==typeof DF["set-"+d+"-type"][e]||"undefined"==typeof DF["set-"+d+"-grid"][e]||"undefined"==typeof DF["set-"+d+"-view"][e])for(var g=!0,h=e;g;)h--,g=!1,void 0===a[0].data.btnUse&&(g=!0,void 0!==DF["set-"+d+"-btn"][h]&&(a[0].data.btnUse=DF["set-"+d+"-btn"][h])),void 0===a[0].data.type&&(g=!0,void 0!==DF["set-"+d+"-type"][h]&&(a[0].data.type=DF["set-"+d+"-type"][h])),void 0===a[0].data.grid&&(g=!0,void 0!==DF["set-"+d+"-grid"][h]&&(a[0].data.grid=DF["set-"+d+"-grid"][h])),void 0===a[0].data.view&&(g=!0,void 0!==DF["set-"+d+"-view"][h]&&(a[0].data.view=DF["set-"+d+"-view"][h]))}var i=a[0].data=$DF.extend(!0,{btnUse:"off",btnList:"fade, grid1, grid2, grid3, grid4, grid5, note",type:"list",grid:"grid3",view:"normal",gridMatch:{note:2},gridMargin:0},a[0].data);i.grid=i.grid.replace("grid",""),(parseInt(i.grid)&&c.children(".df-prl-item").length<=parseInt(i.grid)||!parseInt(i.grid)&&c.children(".df-prl-item").length<=i.gridMatch[i.grid])&&(i.type="list"),b.init=function(){"on"==i.btnUse&&b.setButton(),b.setView(),b.setGrid(),b.setType()},b.setButton=function(){if(!(-1<i.type.indexOf("slide"))){if(!f){var d=i.btnList.replace(/ /g,"").split(",");f="<div class=\"df-prl-viewtype-btn\">"+(-1<d.indexOf("fade")?"<div class=\"df-prl-viewtype-btn-view\"><span></span><span></span><span></span><span></span></div>":"")+(-1<d.indexOf("grid1")?"<div class=\"df-prl-viewtype-btn-grid_1\"><span></span><span></span></div>":"")+(-1<d.indexOf("grid2")?"<div class=\"df-prl-viewtype-btn-grid_2\"><span></span><span></span><span></span><span></span></div>":"")+(-1<d.indexOf("grid3")?"<div class=\"df-prl-viewtype-btn-grid_3\"><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span></div>":"")+(-1<d.indexOf("grid4")?"<div class=\"df-prl-viewtype-btn-grid_4\"><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span></div>":"")+(-1<d.indexOf("grid5")?"<div class=\"df-prl-viewtype-btn-grid_5\"><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span></div>":"")+(-1<d.indexOf("note")?"<div class=\"df-prl-viewtype-btn-grid_note\"><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span></div>":"")+"</div>"}"prlnorm"==i.code||"prlsrch"==i.code?(i.$button=$DF(".df-prl-viewtype-btn-wrap").append(f).find(".df-prl-viewtype-btn"),!i.$button.length&&(c.before(f),i.$button=a.find(".df-prl-viewtype-btn"))):(c.before(f),i.$button=a.find(".df-prl-viewtype-btn"));var e=i.$button.children("div"),g=function(){"fade"==i.view?e.filter(".df-prl-viewtype-btn-view").addClass("selected"):"normal"==i.view&&e.filter(".df-prl-viewtype-btn-view").removeClass("selected"),0<parseInt(i.grid)?e.filter(".df-prl-viewtype-btn-view").removeClass("disabled"):"note"==i.grid&&e.filter(".df-prl-viewtype-btn-view").addClass("disabled"),e.filter(".df-prl-viewtype-btn-grid_"+i.grid).addClass("selected").siblings().not(".df-prl-viewtype-btn-view").removeClass("selected"),b.setView(),b.setGrid()};g(),e.on("click",function(){var a=$DF(this);a.hasClass("disabled")||(a.hasClass("df-prl-viewtype-btn-view")?a.hasClass("selected")?i.view="normal":i.view="fade":a.hasClass("df-prl-viewtype-btn-grid_1")?i.grid="1":a.hasClass("df-prl-viewtype-btn-grid_2")?i.grid="2":a.hasClass("df-prl-viewtype-btn-grid_3")?i.grid="3":a.hasClass("df-prl-viewtype-btn-grid_4")?i.grid="4":a.hasClass("df-prl-viewtype-btn-grid_5")?i.grid="5":a.hasClass("df-prl-viewtype-btn-grid_note")&&(i.grid="note"),g(),"slide"==i.type&&b.setType())})}},b.setType=function(){if(-1<i.type.indexOf("slide")){var a=parseInt(i.type.replace("slide","")),b=0<parseInt(i.grid)?parseInt(i.grid):i.gridMatch[i.grid];i.gridMargin=parseInt(c.css("gap"));var d={loop:!0,slidesPerView:b,slidesPerGroup:b,speed:700,spaceBetween:i.gridMargin,resizeReInit:!0,autoHeight:!1,autoplay:{delay:4500},df:{rows:1<a?a:1,navigation:{use:!0,addClass:"df-slider-nav-hover-off df-slider-nav-size-medium df-slider-nav-shape-circle df-slider-nav-color-white"},pagination:{use:!0},autoPlay:!0,autoplayHover:!0}};if(i.loadedTypeSlide)return i.slider[0].params.slidesPerView=d.slidesPerView,i.slider[0].params.slidesPerGroup=d.slidesPerGroup,i.slider[0].params.effect=d.effect,i.slider[0].params.spaceBetween=d.spaceBetween,void i.slider[0].update();i.slider=df_slider(c,d),i.loadedTypeSlide=!0}else"list"==i.type&&c.removeClass("df-items-standby")},b.setGrid=function(){c.removeClass("df-prl-items_grid_1 df-prl-items_grid_2 df-prl-items_grid_3 df-prl-items_grid_4 df-prl-items_grid_5 df-prl-items_grid_note"),c.addClass("df-prl-items_grid_"+i.grid),"note"==i.grid&&c.removeClass("df-prl-items_boxfade")},b.setView=function(){"fade"==i.view?c.addClass("df-prl-items_boxfade"):"normal"==i.view&&c.removeClass("df-prl-items_boxfade")},b.init()}},d={"xans-product-listmain":"prlmain","xans-product-listrecommend":"prlrcmd","xans-product-listnormal":"prlnorm","xans-project-list":"prlproj","xans-search-result":"prlsrch"},e={},f="";b.each(function(a){var b=$DF(this);for(key in d)if(b.hasClass(key)){e[key]||(e[key]=0),e[key]++,b[0].data={},b[0].data.btnUse=DF["set-"+d[key]+"-btn"][e[key]],b[0].data.btnList=DF["set-productlist-btn"],b[0].data.type=DF["set-"+d[key]+"-type"][e[key]],b[0].data.grid=DF["set-"+d[key]+"-grid"][e[key]],b[0].data.view=DF["set-"+d[key]+"-view"][e[key]],b[0].data.code=d[key],b[0].data.index=a,c(b);break}}),a.css("opacity","1")}}(),function(){var a=$DF(".xans-product-listrecommend");if(a.length){var b=a.children(".df-slider").length;if(b){for(var c=a.find(".swiper-slide"),d=c.not(".swiper-slide-duplicate"),e=d.find(".df-prl-label"),f=label_normal_count=e.length,g=0;g<f;g++)e.eq(g).append(" <span class=\"df-prl-label-no\">"+(g+1)+"</span>");for(var h=d.eq(0).prevAll(),e=h.find(".df-prl-label"),f=e.length,g=0;g<f;g++)e.eq(g).append(" <span class=\"df-prl-label-no\">"+(label_normal_count-f+g+1)+"</span>");for(var j=d.eq(d.length-1).nextAll(),e=j.find(".df-prl-label"),f=e.length,g=0;g<f;g++)e.eq(g).append(" <span class=\"df-prl-label-no\">"+(g+1)+"</span>")}else for(var c=a.find(".swiper-slide"),e=a.find(".df-prl-label"),f=e.length,g=0;g<f;g++)e.eq(g).append(" <span class=\"df-prl-label-no\">"+(g+1)+"</span>")}}();

/**
 * jQuery CSS Customizable Scrollbar
 *
 * Copyright 2015, Yuriy Khabarov
 * Dual licensed under the MIT or GPL Version 2 licenses.
 *
 * If you found bug, please contact me via email <13real008@gmail.com>
 *
 * @author Yuriy Khabarov aka Gromo
 * @version 0.2.10
 * @url https://github.com/gromo/jquery.scrollbar/
 *
 */
/*
마지막 업데이트 : 2020-12-16
*/


!function(m){"use strict";var d={data:{index:0,name:"scrollbar"},macosx:/mac/i.test(navigator.platform),mobile:/android|webos|iphone|ipad|ipod|blackberry/i.test(navigator.userAgent),overlay:null,scroll:null,scrolls:[],webkit:/webkit/i.test(navigator.userAgent)&&!/edge\/\d+/i.test(navigator.userAgent)};d.scrolls.add=function(l){this.remove(l).push(l)};function l(l){var e;d.scroll||(d.overlay=!((e=t(!0)).height||e.width),d.scroll=t(),a(),m(window).resize(function(){var l,e=!1;d.scroll&&(d.scroll.height||d.scroll.width)&&((l=t()).height===d.scroll.height&&l.width===d.scroll.width||(d.scroll=l,e=!0)),a(e)})),this.container=l,this.namespace=".scrollbar_"+d.data.index++,this.options=m.extend({},o,window.jQueryScrollbarOptions||{}),this.scrollTo=null,this.scrollx={},this.scrolly={},l.data(d.data.name,this),d.scrolls.add(this)}var o={autoScrollSize:!0,autoUpdate:!0,debug:!(d.scrolls.remove=function(l){for(;0<=m.inArray(l,this);)this.splice(m.inArray(l,this),1);return this}),disableBodyScroll:!1,duration:200,ignoreMobile:!1,ignoreOverlay:!1,scrollStep:30,showArrows:!1,stepScrolling:!0,scrollx:null,scrolly:null,onDestroy:null,onInit:null,onScroll:null,onUpdate:null};l.prototype={destroy:function(){var l,e;this.wrapper&&(this.container.removeData(d.data.name),d.scrolls.remove(this),l=this.container.scrollLeft(),e=this.container.scrollTop(),this.container.insertBefore(this.wrapper).css({height:"",margin:"","max-height":""}).removeClass("scroll-content scroll-scrollx_visible scroll-scrolly_visible").off(this.namespace).scrollLeft(l).scrollTop(e),this.scrollx.scroll.removeClass("scroll-scrollx_visible").find("div").andSelf().off(this.namespace),this.scrolly.scroll.removeClass("scroll-scrolly_visible").find("div").andSelf().off(this.namespace),this.wrapper.remove(),m(document).add("body").off(this.namespace),m.isFunction(this.options.onDestroy)&&this.options.onDestroy.apply(this,[this.container]))},init:function(l){var e,p=this,u=this.container,r=this.containerWrapper||u,f=this.namespace,v=m.extend(this.options,l||{}),b={x:this.scrollx,y:this.scrolly},o=this.wrapper,s={scrollLeft:u.scrollLeft(),scrollTop:u.scrollTop()};if(d.mobile&&v.ignoreMobile||d.overlay&&v.ignoreOverlay||d.macosx&&!d.webkit)return!1;o?r.css({height:"auto","margin-bottom":-1*d.scroll.height+"px","margin-right":-1*d.scroll.width+"px","max-height":""}):(this.wrapper=o=m("<div>").addClass("scroll-wrapper").addClass(u.attr("class")).css("position","absolute"==u.css("position")?"absolute":"relative").insertBefore(u).append(u),u.is("textarea")&&(this.containerWrapper=r=m("<div>").insertBefore(u).append(u),o.addClass("scroll-textarea")),r.addClass("scroll-content").css({height:"auto","margin-bottom":-1*d.scroll.height+"px","margin-right":-1*d.scroll.width+"px","max-height":""}),u.on("scroll"+f,function(l){m.isFunction(v.onScroll)&&v.onScroll.call(p,{maxScroll:b.y.maxScrollOffset,scroll:u.scrollTop(),size:b.y.size,visible:b.y.visible},{maxScroll:b.x.maxScrollOffset,scroll:u.scrollLeft(),size:b.x.size,visible:b.x.visible}),b.x.isVisible&&b.x.scroll.bar.css("left",u.scrollLeft()*b.x.kx+"px"),b.y.isVisible&&b.y.scroll.bar.css("top",u.scrollTop()*b.y.kx+"px")}),o.on("scroll"+f,function(){o.scrollTop(0).scrollLeft(0)}),v.disableBodyScroll&&(e=function(l){g(l)?b.y.isVisible&&b.y.mousewheel(l):b.x.isVisible&&b.x.mousewheel(l)},o.on("MozMousePixelScroll"+f,e),o.on("mousewheel"+f,e),d.mobile&&o.on("touchstart"+f,function(l){var e=l.originalEvent.touches&&l.originalEvent.touches[0]||l,o=e.pageX,s=e.pageY,r=u.scrollLeft(),t=u.scrollTop();m(document).on("touchmove"+f,function(l){var e=l.originalEvent.targetTouches&&l.originalEvent.targetTouches[0]||l;u.scrollLeft(r+o-e.pageX),u.scrollTop(t+s-e.pageY),l.preventDefault()}),m(document).on("touchend"+f,function(){m(document).off(f)})})),m.isFunction(v.onInit)&&v.onInit.apply(this,[u])),m.each(b,function(r,t){function i(){var l=u[a]();u[a](l+d),1==c&&h<=l+d&&(l=u[a]()),-1==c&&l+d<=h&&(l=u[a]()),u[a]()==l&&n&&n()}var n=null,c=1,a="x"===r?"scrollLeft":"scrollTop",d=v.scrollStep,h=0;t.scroll||(t.scroll=p._getScroll(v["scroll"+r]).addClass("scroll-"+r),v.showArrows&&t.scroll.addClass("scroll-element_arrows_visible"),t.mousewheel=function(l){if(!t.isVisible||"x"===r&&g(l))return!0;if("y"===r&&!g(l))return b.x.mousewheel(l),!0;var e=-1*l.originalEvent.wheelDelta||l.originalEvent.detail,o=t.size-t.visible-t.offset;return(0<e&&h<o||e<0&&0<h)&&((h+=e)<0&&(h=0),o<h&&(h=o),p.scrollTo=p.scrollTo||{},p.scrollTo[a]=h,setTimeout(function(){p.scrollTo&&(u.stop().animate(p.scrollTo,240,"linear",function(){h=u[a]()}),p.scrollTo=null)},1)),l.preventDefault(),!1},t.scroll.on("MozMousePixelScroll"+f,t.mousewheel).on("mousewheel"+f,t.mousewheel).on("mouseenter"+f,function(){h=u[a]()}),t.scroll.find(".scroll-arrow, .scroll-element_track").on("mousedown"+f,function(l){if(1!=l.which)return!0;c=1;var e={eventOffset:l["x"===r?"pageX":"pageY"],maxScrollValue:t.size-t.visible-t.offset,scrollbarOffset:t.scroll.bar.offset()["x"===r?"left":"top"],scrollbarSize:t.scroll.bar["x"===r?"outerWidth":"outerHeight"]()},o=0,s=0;return h=m(this).hasClass("scroll-arrow")?(c=m(this).hasClass("scroll-arrow_more")?1:-1,d=v.scrollStep*c,0<c?e.maxScrollValue:0):(c=e.scrollbarOffset+e.scrollbarSize<e.eventOffset?1:e.eventOffset<e.scrollbarOffset?-1:0,d=Math.round(.75*t.visible)*c,h=e.eventOffset-e.scrollbarOffset-(v.stepScrolling?1==c?e.scrollbarSize:0:Math.round(e.scrollbarSize/2)),u[a]()+h/t.kx),p.scrollTo=p.scrollTo||{},p.scrollTo[a]=v.stepScrolling?u[a]()+d:h,v.stepScrolling&&(n=function(){h=u[a](),clearInterval(s),clearTimeout(o),s=o=0},o=setTimeout(function(){s=setInterval(i,40)},v.duration+100)),setTimeout(function(){p.scrollTo&&(u.animate(p.scrollTo,v.duration),p.scrollTo=null)},1),p._handleMouseDown(n,l)}),t.scroll.bar.on("mousedown"+f,function(l){if(1!=l.which)return!0;var o=l["x"===r?"pageX":"pageY"],s=u[a]();return t.scroll.addClass("scroll-draggable"),m(document).on("mousemove"+f,function(l){var e=parseInt((l["x"===r?"pageX":"pageY"]-o)/t.kx,10);u[a](s+e)}),p._handleMouseDown(function(){t.scroll.removeClass("scroll-draggable"),h=u[a]()},l)}))}),m.each(b,function(l,e){var o="scroll-scroll"+l+"_visible",s="x"==l?b.y:b.x;e.scroll.removeClass(o),s.scroll.removeClass(o),r.removeClass(o)}),m.each(b,function(l,e){m.extend(e,"x"==l?{offset:parseInt(u.css("left"),10)||0,size:u.prop("scrollWidth"),visible:o.width()}:{offset:parseInt(u.css("top"),10)||0,size:u.prop("scrollHeight"),visible:o.height()})}),this._updateScroll("x",this.scrollx),this._updateScroll("y",this.scrolly),m.isFunction(v.onUpdate)&&v.onUpdate.apply(this,[u]),m.each(b,function(l,e){var o="x"===l?"left":"top",s="x"===l?"outerWidth":"outerHeight",r="x"===l?"width":"height",t=parseInt(u.css(o),10)||0,i=e.size,n=e.visible+t,c=e.scroll.size[s]()+(parseInt(e.scroll.size.css(o),10)||0);v.autoScrollSize&&(e.scrollbarSize=parseInt(c*n/i,10),e.scroll.bar.css(r,e.scrollbarSize+"px")),e.scrollbarSize=e.scroll.bar[s](),e.kx=(c-e.scrollbarSize)/(i-n)||1,e.maxScrollOffset=i-n}),u.scrollLeft(s.scrollLeft).scrollTop(s.scrollTop).trigger("scroll")},_getScroll:function(l){var e={advanced:['<div class="scroll-element">','<div class="scroll-element_corner"></div>','<div class="scroll-arrow scroll-arrow_less"></div>','<div class="scroll-arrow scroll-arrow_more"></div>','<div class="scroll-element_outer">','<div class="scroll-element_size"></div>','<div class="scroll-element_inner-wrapper">','<div class="scroll-element_inner scroll-element_track">','<div class="scroll-element_inner-bottom"></div>',"</div>","</div>",'<div class="scroll-bar">','<div class="scroll-bar_body">','<div class="scroll-bar_body-inner"></div>',"</div>",'<div class="scroll-bar_bottom"></div>','<div class="scroll-bar_center"></div>',"</div>","</div>","</div>"].join(""),simple:['<div class="scroll-element">','<div class="scroll-element_outer">','<div class="scroll-element_size"></div>','<div class="scroll-element_track"></div>','<div class="scroll-bar"></div>',"</div>","</div>"].join("")};return e[l]&&(l=e[l]),l="string"==typeof(l=l||e.simple)?m(l).appendTo(this.wrapper):m(l),m.extend(l,{bar:l.find(".scroll-bar"),size:l.find(".scroll-element_size"),track:l.find(".scroll-element_track")}),l},_handleMouseDown:function(l,e){var o=this.namespace;return m(document).on("blur"+o,function(){m(document).add("body").off(o),l&&l()}),m(document).on("dragstart"+o,function(l){return l.preventDefault(),!1}),m(document).on("mouseup"+o,function(){m(document).add("body").off(o),l&&l()}),m("body").on("selectstart"+o,function(l){return l.preventDefault(),!1}),e&&e.preventDefault(),!1},_updateScroll:function(l,e){var o=this.container,s=this.containerWrapper||o,r="scroll-scroll"+l+"_visible",t="x"===l?this.scrolly:this.scrollx,i=parseInt(this.container.css("x"===l?"left":"top"),10)||0,n=this.wrapper,c=e.size,a=e.visible+i;e.isVisible=1<c-a,e.isVisible?(e.scroll.addClass(r),t.scroll.addClass(r),s.addClass(r)):(e.scroll.removeClass(r),t.scroll.removeClass(r),s.removeClass(r)),"y"===l&&0<c&&(o.is("textarea")||c<a?s.css({height:a+d.scroll.height+"px","max-height":"none"}):s.css({"max-height":a+d.scroll.height+"px"})),e.size==o.prop("scrollWidth")&&t.size==o.prop("scrollHeight")&&e.visible==n.width()&&t.visible==n.height()&&e.offset==(parseInt(o.css("left"),10)||0)&&t.offset==(parseInt(o.css("top"),10)||0)||(m.extend(this.scrollx,{offset:parseInt(o.css("left"),10)||0,size:o.prop("scrollWidth"),visible:n.width()}),m.extend(this.scrolly,{offset:parseInt(o.css("top"),10)||0,size:this.container.prop("scrollHeight"),visible:n.height()}),this._updateScroll("x"===l?"y":"x",t))}};var r=l;m.fn.scrollbar=function(o,s){return"string"!=typeof o&&(s=o,o="init"),void 0===s&&(s=[]),m.isArray(s)||(s=[s]),this.not("body, .scroll-wrapper").each(function(){var l=m(this),e=l.data(d.data.name);(e||"init"===o)&&(e=e||new r(l))[o]&&e[o].apply(e,s)}),this},m.fn.scrollbar.options=o;var c,s,a=(c=0,function(l){for(var e,o,s,r,t,i,n=0;n<d.scrolls.length;n++)e=(s=d.scrolls[n]).container,o=s.options,r=s.wrapper,t=s.scrollx,i=s.scrolly,(l||o.autoUpdate&&r&&r.is(":visible")&&(e.prop("scrollWidth")!=t.size||e.prop("scrollHeight")!=i.size||r.width()!=t.visible||r.height()!=i.visible))&&(s.init(),!o.debug||window.console&&console.log({scrollHeight:e.prop("scrollHeight")+":"+s.scrolly.size,scrollWidth:e.prop("scrollWidth")+":"+s.scrollx.size,visibleHeight:r.height()+":"+s.scrolly.visible,visibleWidth:r.width()+":"+s.scrollx.visible},!0));clearTimeout(c),c=setTimeout(a,300)});function t(l){return d.webkit&&!l?{height:0,width:0}:(d.data.outer||(e={border:"none","box-sizing":"content-box",height:"200px",margin:"0",padding:"0",width:"200px"},d.data.inner=m("<div>").css(m.extend({},e)),d.data.outer=m("<div>").css(m.extend({left:"-1000px",overflow:"scroll",position:"absolute",top:"-1000px"},e)).append(d.data.inner).appendTo("body")),d.data.outer.scrollLeft(1e3).scrollTop(1e3),{height:Math.ceil(d.data.outer.offset().top-d.data.inner.offset().top||0),width:Math.ceil(d.data.outer.offset().left-d.data.inner.offset().left||0)});var e}function g(l){var e=l.originalEvent;return!(e.axis&&e.axis===e.HORIZONTAL_AXIS||e.wheelDeltaX)}window.angular&&(s=window.angular).module("jQueryScrollbar",[]).provider("jQueryScrollbar",function(){var e=o;return{setOptions:function(l){s.extend(e,l)},$get:function(){return{options:s.copy(e)}}}}).directive("jqueryScrollbar",["jQueryScrollbar","$parse",function(r,t){return{restrict:"AC",link:function(l,e,o){var s=t(o.jqueryScrollbar)(l);e.scrollbar(s||r.options).on("$destroy",function(){e.scrollbar("destroy")})}}}])}($DF);

/**
	======================================================================================================

		D E S I G N F L O O R

		이 쇼핑몰은 디자인플로어 서비스를 이용하고 있습니다.

		[대표전화] 1544-4941
		[홈페이지] www.dfloor.co.kr
		[특허청출원번호] 4120150030498

		디자인의 모든 저작권은 디자인플로어에 있으며, 1Copy 라이선스로 최초 적용된 쇼핑몰에서만 사용권을
		부여합니다. 디자인플로어 콘텐츠의 모든 라이선스는 아래의 '법적 고지'를 따릅니다.

	======================================================================================================

		※디자인플로어 라이선스 법적 고지※

		-본 사이트에 존재하는 모든 기술적 소스코드의 저작권은 오직 디자인플로어에 있습니다.
		-본 사이트에 존재하는 기술적 소스코드를 사용할 경우와 이를 변형하여 활용하는 경우
		 저작권법에 의거 법적 고지를 위반하는 것으로 판단하며 즉각 민형사상의 조치를 취합니다.
		-디자인플로어는 디자인의 개발·생산 및 콘텐츠의 보호를 가장 우선으로 하므로 진행되는
		 민형사소송건에 대한 합의는 진행하지 않는 점을 고지합니다.
		-디자인플로어는 민가율 합동 법률사무소 '김석호 변호사'와 함께 지적재산권을 수호하며
		 자문을 받고 있습니다.

	======================================================================================================
**/
/**
	업데이트: 2023-09-11
**/

// 설정파일 관련(P+M) 2020-11-23
var _0x307a=['createElement','getElementById','join','call','}-->','indexOf','splice','appendChild','put','split','off','outerHTML','replace','keys','<!--{','add','use','df-use-on','classList','getElementsByClassName','df-','set','rep','innerHTML','ins','remove','forEach','length','prototype'];(function(_0x4ada47,_0x184d1f){var _0x307abf=function(_0x422809){while(--_0x422809){_0x4ada47['push'](_0x4ada47['shift']());}};_0x307abf(++_0x184d1f);}(_0x307a,0xef));var _0x4228=function(_0x4ada47,_0x184d1f){_0x4ada47=_0x4ada47-0x155;var _0x307abf=_0x307a[_0x4ada47];return _0x307abf;};(function(){var _0x51ddf4=_0x4228;Object[_0x51ddf4(0x15b)](DF)['forEach'](function(_0x865976){var _0x287ac3=_0x51ddf4,_0x576266=_0x865976['split']('-'),_0x541c80=_0x576266[0x0];if(_0x541c80===_0x287ac3(0x163))return;var _0x2c4cab=DF[_0x865976],_0x531f28='',_0x143a27=[],_0x282058=![];if(_0x541c80===_0x287ac3(0x15e))_0x531f28=document['getElementById'](_0x287ac3(0x162)+_0x865976),!_0x531f28&&(_0x143a27=document[_0x287ac3(0x161)]('df-'+_0x865976));else{var _0x80a8c3=_0x865976[_0x287ac3(0x157)]('-');_0x80a8c3[_0x287ac3(0x171)](_0x80a8c3[_0x287ac3(0x169)]-0x1,0x1),_0x80a8c3=_0x80a8c3[_0x287ac3(0x16d)]('-'),_0x531f28=document[_0x287ac3(0x16c)](_0x287ac3(0x162)+_0x80a8c3);if(!_0x531f28)_0x143a27=document[_0x287ac3(0x161)](_0x287ac3(0x162)+_0x80a8c3);}if(!_0x531f28&&_0x143a27[_0x287ac3(0x169)]===0x0)return;if(!_0x531f28)_0x282058=!![];if(_0x541c80===_0x287ac3(0x15e)){if(_0x2c4cab==='on')_0x282058?Array['prototype'][_0x287ac3(0x168)][_0x287ac3(0x16e)](_0x143a27,function(_0x5c4dda){var _0xca5bc0=_0x287ac3;_0x5c4dda[_0xca5bc0(0x160)][_0xca5bc0(0x15d)](_0xca5bc0(0x15f));}):_0x531f28['classList'][_0x287ac3(0x15d)]('df-use-on');else _0x2c4cab===_0x287ac3(0x158)&&(_0x282058?$DF(_0x143a27)[_0x287ac3(0x167)]():$DF(_0x531f28)['remove']());}else{if(_0x541c80===_0x287ac3(0x156))_0x282058?Array[_0x287ac3(0x16a)][_0x287ac3(0x168)][_0x287ac3(0x16e)](_0x143a27,function(_0x18fa70){var _0xb23b77=_0x287ac3;_0x18fa70['setAttribute'](_0x576266[_0x576266[_0xb23b77(0x169)]-0x1],_0x2c4cab);}):_0x531f28['setAttribute'](_0x576266[_0x576266[_0x287ac3(0x169)]-0x1],_0x2c4cab);else{if(_0x541c80===_0x287ac3(0x164)){if(_0x282058)Array[_0x287ac3(0x16a)][_0x287ac3(0x168)][_0x287ac3(0x16e)](_0x143a27,function(_0xa391b4){var _0x4ccb08=_0x287ac3,_0x5c1cd2=_0xa391b4[_0x4ccb08(0x159)];if(_0x5c1cd2[_0x4ccb08(0x170)]('<!--{'+_0x865976+_0x4ccb08(0x16f))>=0x0)_0xa391b4['outerHTML']=_0x5c1cd2=_0x5c1cd2[_0x4ccb08(0x15a)](_0x4ccb08(0x15c)+_0x865976+_0x4ccb08(0x16f),_0x2c4cab);if(_0x5c1cd2[_0x4ccb08(0x170)]('{'+_0x865976+'}')>=0x0)_0xa391b4[_0x4ccb08(0x159)]=_0x5c1cd2=_0x5c1cd2[_0x4ccb08(0x15a)]('{'+_0x865976+'}',_0x2c4cab);});else{var _0x3d5ea2=_0x531f28[_0x287ac3(0x159)];if(_0x3d5ea2['indexOf'](_0x287ac3(0x15c)+_0x865976+_0x287ac3(0x16f))>=0x0)_0x531f28[_0x287ac3(0x159)]=_0x3d5ea2=_0x3d5ea2[_0x287ac3(0x15a)](_0x287ac3(0x15c)+_0x865976+'}-->',_0x2c4cab);if(_0x3d5ea2[_0x287ac3(0x170)]('{'+_0x865976+'}')>=0x0)_0x531f28[_0x287ac3(0x159)]=_0x3d5ea2=_0x3d5ea2['replace']('{'+_0x865976+'}',_0x2c4cab);}}else _0x541c80===_0x287ac3(0x166)&&(_0x282058?Array[_0x287ac3(0x16a)][_0x287ac3(0x168)]['call'](_0x143a27,function(_0xda08ca){var _0xcca0fe=_0x287ac3;Object[_0xcca0fe(0x15b)](_0x2c4cab)[_0xcca0fe(0x168)](function(_0x3fe705,_0x5b9434){var _0x59adc7=_0xcca0fe,_0x41de23=document[_0x59adc7(0x16b)](_0x576266[_0x576266[_0x59adc7(0x169)]-0x1]);_0x41de23['classList'][_0x59adc7(0x15d)](_0x80a8c3+'-'+_0x3fe705),_0x41de23[_0x59adc7(0x165)]=_0x2c4cab[_0x3fe705],_0xda08ca['appendChild'](_0x41de23);});}):Object[_0x287ac3(0x15b)](_0x2c4cab)[_0x287ac3(0x168)](function(_0x55be05,_0x4137c3){var _0x2b531a=_0x287ac3,_0x5bbe5d=document['createElement'](_0x576266[_0x576266[_0x2b531a(0x169)]-0x1]);_0x5bbe5d[_0x2b531a(0x160)][_0x2b531a(0x15d)](_0x80a8c3+'-'+_0x55be05),_0x5bbe5d[_0x2b531a(0x165)]=_0x2c4cab[_0x55be05],_0x531f28[_0x2b531a(0x155)](_0x5bbe5d);}));}}});}());



/********** DF 헤더영역 시작 **********/
var $header = $DF('#header');
if($header.length){


	// 상단 영역 픽스 2020-12-04
	!function(){var n,s,t,o=$DF(document),f=$DF(window),r=$DF(".df-fixed-object");r.length&&(n={0:0},s=0,t=function(e,t,o){for(n[o+1]=r.eq(o).outerHeight(),e.parent().height(e.outerHeight()),i=0;i<=o;i++)s+=n[i];0==e.hasClass("fixed")&&f.scrollTop()>e.parent().offset().top-s?(e.addClass("fixed"),e.css({top:s}),n[o+1]=r.eq(o).outerHeight(),e.parent().height(e.outerHeight())):1==e.hasClass("fixed")&&f.scrollTop()<=e.parent().offset().top-s&&(e.removeClass("fixed"),e.parent().height("")),s=0},r.each(function(e){t(r.eq(e),0,e),o.on("scroll",function(){t(r.eq(e),0,e)}),f.on("resize",function(){t(r.eq(e),0,e)})}))}();


	// 상단 로고 롤오버 2020-11-23
	!function(){var f=$DF("#df-logo");f.length&&1<f.find(".df-logo-item").length&&f.addClass("df-logo-effect")}();


}
/********** DF 헤더영역 끝 **********/



/********** DF 메인영역 시작 **********/
var $wrap = $DF('#wrap');
if($wrap.hasClass('df-wrap-main')){


	// 메인 슬라이드 배너 2020-12-05
	!function(){var e,i,t,s,a,n,d=$DF(".df-mainslide");d.length&&(e=d.find(".df-mainslide-items"),"top"===DF["set-mainslider-position"]&&d.css({opacity:"0",visibility:"hidden"}),t=void 0!==DF["set-mainslider-effect"]?DF["set-mainslider-effect"]:"fade",s=0<parseInt(DF["set-mainslider-pause"])?parseInt(DF["set-mainslider-pause"]):4500,a=0<parseInt(DF["set-mainslider-speed"])?parseInt(DF["set-mainslider-speed"]):400,n=void 0!==DF["set-mainslider-pager"]&&DF["set-mainslider-pager"],df_slider(e,{loop:!0,autoplay:{delay:s},speed:a,effect:t,df:{navigation:{use:!0,addClass:"df-content-wrap df-slider-nav-hover-on df-slider-nav-size-big df-slider-nav-shape-box df-slider-nav-color-gray"},pagination:{use:!0,timer:!0,text:!0,type:n},youtube:{use:!0,autoPlay:!0,timer:!0,controllWrap:!0,controllPage:!0},autoPlay:!0,autoplayHover:!0,onInitAfter:function(){var e;"top"===DF["set-mainslider-position"]&&(e=$DF("#header"),df_loadElements($DF("#df-logo"),"img",function(){i=e.outerHeight(),d.find(".swiper-button-prev").add(d.find(".swiper-button-next")).css("margin-top",i/2+"px"),d.css({opacity:"1",visibility:"visible","margin-top":-i+"px"})}))}}}))}();


	// 메인 멀티 슬라이드 배너 2020-12-05
	!function(){var e,d=$DF(".df-multislide");d.length&&(e=d.find(".df-multislide-items"),df_slider(e,{loop:!0,autoplay:{delay:4500},speed:700,slidesPerView:2,slidesPerGroup:2,spaceBetween:2,df:{navigation:{use:!0,addClass:"df-slider-nav-hover-off df-slider-nav-size-medium df-slider-nav-shape-circle df-slider-nav-color-gray"},pagination:{use:!0,type:"circle"},autoPlay:!0,autoplayHover:!0}}))}();


	// 메인 분류별 배너 2023-08-18
	$divbanner=$DF(".df-divbanner"),$divbanner.length&&($DF.dfdivbanner=function(e,a){var r,s,o,f,l,v={object:null,classname:"df-divbanner",start:1,position:"after",initBefore:function(){return!0},initAfter:function(){return!0}},c={},b=$DF(e);c.init=function(){if(r=c.settings=$DF.extend({},v,a),"undefined"!=typeof setSize){if(r.initBefore.call(c,b),null==r.object)return!1;if(s=r.object,(o=s.length)<=0)return b.addClass(r.classname).show(),!1;if(f=b.find(".df-divbanner-item").detach(),(l=f.length)<=0)return!1;for(var e=!1,n=0;n<l;n++)var i,t,d=s.eq(n),e=d.length?("before"==r.position?d.before('<div class="'+r.classname+" df-divbanner-type_"+r.position+'">'+f.eq(n)[0].outerHTML+"</div>"):"after"==r.position?d.after('<div class="'+r.classname+" df-divbanner-type_"+r.position+'">'+f.eq(n)[0].outerHTML+"</div>"):"middle"==r.position&&((i=d.find(".df-slider")).length?i.before('<div class="'+r.classname+" df-divbanner-type_"+r.position+'">'+f.eq(n)[0].outerHTML+"</div>"):d.find(".df-prl-items").before('<div class="'+r.classname+' df-divbanner-type_middle">'+f.eq(n)[0].outerHTML+"</div>")),!0):(e&&"after"!=r.position?(t='<div class="'+r.classname+" df-divbanner-type_"+r.position+'">'+f.eq(n)[0].outerHTML+"</div>",s.eq(o-1).after(t)):(t='<div class="'+r.classname+" df-divbanner-type_"+r.position+'">'+f.eq(n)[0].outerHTML+"</div>",$DF(".df-divbanner-items").last().after(t)),!1);r.initAfter.call(c,b)}},c.init()},$DF.fn.dfdivbanner=function(i){return this.each(function(){if("undefined"!=typeof setSize){var e=$DF(this),n=e.data("dfdivbanner");return n?n.methods[i]?n.methods[i].apply(this,Array.prototype.slice.call(arguments,1)):void 0:(n=new $DF.dfdivbanner(this,i),e.data("dfdivbanner",n),n)}})},$divbanner.dfdivbanner({object:$DF(".xans-product-listmain, .df-add-mainlist"),classname:"df-divbanner-items df-bannermanager",position:DF["set-divbanner-position"]}));



}
/********** DF 메인영역 끝 **********/



/********** DF 공통(메인제외)영역 시작 **********/
var $wrap = $DF('#wrap');
if($wrap.hasClass('df-wrap-layout')){


	// 상품 상세페이지 관련상품 및 옵션출력 2020-12-01
	!function(){var e,d,a=$DF(".df-prd-related");a.length&&("on"===DF["set-prd-related"]&&a.addClass("df-prd-related_option"),e=a.find(".df-prd-related-items"),d=0<parseInt(DF["set-prd-related-grid"])?parseInt(DF["set-prd-related-grid"]):4,df_slider(e,{simulateTouch:!1,autoplay:{delay:5e3},speed:740,slidesPerView:d,slidesPerGroup:d,spaceBetween:20,df:{navigation:{use:!0,addClass:"df-slider-nav-hover-off df-slider-nav-size-small df-slider-nav-shape-box df-slider-nav-color-white"},pagination:{use:!0,type:"fraction"},autoPlay:!1,autoplayHover:!0}}))}();


	// 게시판 첨부파일 출력제어 2020-11-21
	!function(){var t=$DF("#boardWriteForm");t.length&&t.find(".attachfile").not(".displaynone").each(function(){function n(t){i.find("tr .attachabtnArea").hide(),t.find(".attachabtnArea").show()}var a,i=$DF(this),e=i.find("tr").length,r=i.find("tr input:checkbox").length;i.find("tr").each(function(t){str='<span class="attachabtnArea"> ',t+1<e&&(str+='<a href="#none" class="attachfile-add"><i class="plus"></i></a> '),(0==r&&1<t+1||0<r&&r<t)&&(str+='<a href="#none" class="attachfile-remove"><i class="minus"></i></a>'),str+=" </span>",$DF(this).find("td").append(str),$DF(this).hide(),t<=(a=0<r?r:1)&&($DF(this).show(),a==t&&n($DF(this)))}),i.find(".attachfile-add").click(function(){a=$DF(this).parent().parent().parent().index()+1,e<=a||(i.find("tr").eq(a).show(),n(i.find("tr").eq(a)))}),i.find(".attachfile-remove").click(function(){(a=$DF(this).parent().parent().parent().index())<1||0<r&&a<=r||(i.find("tr").eq(a).hide(),n(i.find("tr").eq(a-1)))})})}();


	// 상품목록 중분류의 전체보기메뉴 미표시 상태일 때 제거하기 2020-03-25
	$DF('.xans-product-menupackage .view-all.displaynone').remove();


	// [PC] 상품 상세페이지 상세이미지(추가이미지폼) 2020-11-23
	// 상세 및 추가 이미지사이즈에 따른 썸네일 페이지네이션 너비 조절 2020-12-18
	// 새탭 방식으로 접근시 썸네일 페이지네이션 출력안되는 증상 처리 2021-02-19
	!function(){var t,i,e,d,a,l,n,s=$DF(".imgArea-wrap");!s.length||(t=s.find(".listImg")).length&&(i=s.find(".BigImage"),1<(d=(e=t.find("ul")).find("li")).length&&(d.eq(0).find(".ThumbImage").attr("src",i.attr("src")),t.show(),(a=s.find(".thumbnail")).find(".detail-image").hide(),a.append(e[0].outerHTML),l=df_slider(e,{spaceBetween:5,slidesPerView:5,watchSlidesVisibility:!0,watchSlidesProgress:!0}),n=function(i){var d,e,n;!i.$imageSlide.length||(d=i.$imageSlide.eq(i.realIndex).find(".ThumbImage")).length&&(e=d.width(),t.width(e),(n=a.find(".swiper-navigation")).length&&n.width(e),l[0].update(),0==e&&df_loadElements(i.$imageSlide,"img",function(){var i=d.width();t.width(i);var e=a.find(".swiper-navigation");e.length&&e.width(i),l[0].update()}))},df_slider(a.children("ul"),{thumbs:{swiper:l[0]},df:{navigation:{use:!0,addClass:"df-slider-nav-hover-off df-slider-nav-size-medium df-slider-nav-shape-circle df-slider-nav-color-white"}},on:{init:function(){this.$imageSlide=a.find(".swiper-slide"),n(this)},slideChange:function(){n(this)},resize:function(){n(this)}}})))}();


	// 상품 상세페이지 구매옵션 픽스 2020-11-22
	!function(){var e;function d(){0==e.hasClass("df-detail-fixed")&&$DF("#df-detail-area").offset().top<$DF(document).scrollTop()?(e.css("height",e.height()),e.addClass("df-detail-fixed")):1==e.hasClass("df-detail-fixed")&&$DF("#df-detail-area").offset().top>=$DF(document).scrollTop()&&(e.removeClass("df-detail-fixed"),e.css("height",""))}void 0===DF["set-prd-optfix"]||"on"!==DF["set-prd-optfix"]||(e=$DF("#df-product-detail")).length&&(1!=$DF.cookie("df-product-detail-option")&&void 0!==$DF.cookie("df-product-detail-option")&&e.addClass("close"),e.find(".infoArea").append('<a href="#none" class="df-detail-fixed-btn"><i>옵<br>션<br>보<br>기</i><span class="line1"></span><span class="line2"></span></a>'),e.find(".df-detail-fixed-btn").on("click",function(){e.toggleClass("close"),$DF.cookie("df-product-detail-option",1==e.hasClass("close")?"0":"1",{expires:1,path:"/",secure:!1})}),$DF(window).scroll(function(){d()}),d())}();


	// 상세페이지 사이즈 가이드 2019-11-28
	$DF(".df-sizeguide .type-personal").click(function(){$DF(this).toggleClass("closed"),$DF(".df-sizeguide-content").slideToggle("normal",function(){})});


	// 상품 상세페이지 상품후기&문의게시판 작성일,조회수 표시설정 2018-10-23
	var $detailBoard=$DF("#prdQnA, #prdReview");$detailBoard.each(function(){var i=$DF(this);i.find(".hit-count.displaynone").length&&i.find(".hit-title").hide(),i.find(".date-count.displaynone").length&&i.find(".date-title").hide()});


	// 상품 상세페이지 상품설명 좌우정렬 2017-02-13
	// 기존 상세페이지 최상단에 반영되었던 스타일을 상세설명(.cont)으로 변경 2020-03-11
	void 0!==DF["set-prd-align"]&&$DF("#df-detail-area .cont").each(function(){$DF(this).css("text-align",DF["set-prd-align"])});


	// 상품 상세페이지 탭이동(디자인 개벌) 2023-07-20
	// 레이지로드 기능 사용시 제 위치를 못찾는 문제로 다른방식으로 변경 2020-03-10
	// 헤더영역 마크업 변경으로 인해 상세 탭 셀렉터 변경 2023-07-20
	$DF("#df-detail-area").each(function(){$DF(".df-prd-tab-position").css("top","-"+($DF(".df-header .df-header-bar").outerHeight()+$DF(".df-header .df-lnb").outerHeight()-2)+"px")});


	// 상품상세페이지 할인율 출력 2021-04-08
	// 할인율 소수점(글로벌) 계산을 위해 parseInt 를 parseFloat 으로 변경 2021-09-14
	!function(){var a,t,r,e,d,p;"off"===DF["set-discountrate"]||(a=$DF("#df-product-detail")).length&&(t=parseFloat(a.attr("df-prd-data-custom").replace(/[^-\.0-9]/g,"")),r=parseFloat(a.attr("df-prd-data-price").replace(/[^-\.0-9]/g,"")),e=parseFloat(a.attr("df-prd-data-sale").split(" ")[0].replace(/[^-\.0-9]/g,"")),p=parseFloat(a.attr("df-prd-data-sale2").split(" ")[0].replace(/[^-\.0-9]/g,"")),isNaN(e)&&(e=p),(p=d=0)<t&&0<e?(d=t,p=e):0<r&&0<e?(d=r,p=e):0<t&&0<r&&(d=t,p=r),rate=Math.round(100-p/d*100),0<rate&&$DF('<div class="discountrate"><span class="rate">'+rate+"</span>% OFF</div>").prependTo(a.find(".infoArea-wrap .infoArea .product_price_css .df-prd-custom-add")))}();


	// 상품요약설명·상품간략설명 스타일 이식 2022-04-12
	$DF(".df-simple-desc").attr("style",$DF(".simple_desc_css span").attr("style")),$DF(".df-summary-desc").attr("style",$DF(".summary_desc_css span").attr("style"));


}
/********** DF 공통(메인제외)영역 끝 **********/



// 검색페이지에서 검색폼과 정렬선택박스 동기화 2020-11-22
!function(){var t,a,r=$DF("#searchForm");r.length&&(t=$DF(".df-prl-sort-wrap").find("select").attr("id","").attr("name",""),a=r.find("#order_by"),t.change(function(){var t=$DF(this);a.val(t.val()),t.attr("disabled",!0),r.submit()}))}();


// df placeholder 2023-09-11
!function(){var l,n=$DF(".df-func-placeholder");n.length&&(l=n.find("input")).on("focus blur",function(n){var e=$DF(this),f=l.parents(".df-func-placeholder").find(".df-func-placeholder_label");"focus"==n.type?f.hide():"blur"==n.type&&""==e.val()&&f.show()})}();


// 썸네일 이미지 엑박일경우 기본값 설정 2020-11-23
$DF("img.thumb,img.ThumbImage,img.BigImage,img.thumbSlide,td.thumb > a > img,#df-review .product-thumb img").each(function(m,e){var i=new Image;i.onerror=function(){e.src="/web/upload/dfloor_base/web/common/nonePrdImage.gif"},i.src=this.src});


// 유튜브·비메오 반응형 부모 요소생성 2019-12-12
$DF('iframe[src*="youtube"],iframe[src*="vimeo"],iframe[src*="tv.naver"],iframe[src*="google"]').wrap('<div class="df-iframe">');


// 탭 2020-11-22
$DF(document).on("click",".df-tab-cell",function(){var t=$DF(this);t.addClass("df-tab-selected").siblings(".df-tab-cell").removeClass("df-tab-selected"),$DF(t.attr("df-data-id")).addClass("df-tab-content-selected").siblings(".df-tab-content").removeClass("df-tab-content-selected")});


// sns 아이콘 사용하면 타이틀 보이기 2016-11-22
$DF("#snslink").each(function(){var i=!1;$DF(this).find("li").each(function(){"none"!=$DF(this).css("display")&&(i=!0)}),1==i&&$DF(this).show()});


// SNS 로그인 관련(회원가입or가입약관 화면) 2021-04-06
$DF(".df-snslogin").each(function(){var a=!1;$DF(this).find(".df-snslogin-item").each(function(){"none"!=$DF(this).css("display")&&(a=!0)}),1==a&&$DF(this).show()});


// 스크롤바 플러그인 실행 2017-09-26
$DF('.scrollbar-macosx').scrollbar();


// 이미지맵 플러그인 실행 2021-08-12
$DF('img[usemap]').rwdImageMaps();


// 기본라벨(일반사용자) 2023-08-07
$DF(".df-ft-corp-copyright").append('<span class="df-copyright df-copyright_design">DESIGNED By <a href="//dfloor.co.kr" target="_blank" rel="noopener noreferrer">DFLOOR</a></span>');


// 블랙라벨(허가된 사이트) 2023-08-07
//$DF(".df-ft-corp-copyright").append('<span class="df-copyright df-copyright_design">DESIGNED By <a href="//dfloor.co.kr" target="_blank" rel="noopener noreferrer">DFLOOR<i class="df-copyright_blacklabel">BLACK LABEL</i></a></span>');
$DF(".df-ft-copyright").append('<span class="df-copyright df-copyright_hosting">HOSTING CAFE24</span><span class="df-copyright df-copyright_design">DESIGNED By <a href="//dfloor.co.kr" target="_blank" rel="noopener noreferrer">DFLOOR<i class="df-copyright_blacklabel">BLACK LABEL</i></a></span>');



/**********************************************************************************************************

	※ 디자인플로어 JAVASCRIPT 커스터마이징 ※
	본 파일은 디자인 커스터마이징 작업 시 더 간편하고, 깔끔하게 작업하기 위해 제작된 파일입니다.
    모든 javascript 수정시 이곳에서 작업하고, 수정된 내용을 기록하시기 바랍니다.

	[필독] 주의사항
	- 쇼핑몰의 javascript수정이 필요한 경우 이 파일에서 작성하여 수정하실 수 있습니다.
	- 작업방식은 원본 javascript 수정하는 것이 아닌, 이곳에서 javascript를 추가선언하는 방식입니다.
	- 작업 전 반드시 디자인백업·복구란에서 디자인을 백업처리 하시기 바랍니다.
	- javascript를 작성하실 때, 작성한 내용은 추후 식별을 위해 반드시 주석으로 기록하시기 바랍니다.
	- html 수정을 한 경우에도 반드시 수정내용을 주석으로 기록하시기 바랍니다.
	- 이곳이 아닌, 원본 파일의 javascript 내용 수정은 금지합니다.
	- 이 규칙을 무시하여 발생하는 문제는 복구작업 이 불가하오니 주의바랍니다.
	- 수정방법·보정·경로·마크업에 관련된 문의는 받지 않습니다.
	- 의뢰시 모든 작업은 수정비용이 발생하거나, 유·무상에 관계없이 작업이 불가할 수 있습니다.

**********************************************************************************************************/



/* 메인 그룹 슬라이드 */
(function(){
    var $container = $DF('.main-group-slider-items');
    if(!$container.length) return;
    df_slider($container, {
        autoplay: {
            delay: 4500,
        },
        speed: 400,
        spaceBetween: 15,
        df: {
            navigation: {
                use: true,
                addClass: 'df-content-wrap df-slider-nav-hover-on df-slider-nav-size-big df-slider-nav-shape-box df-slider-nav-color-gray',
            },
            pagination: {
                use: true,
            },
            autoPlay: true,
            autoplayHover: true,
        },
    });

})();


/* 하단 슬라이드 1단 배너 */
(function(){
    var $container = $DF('.df-bottom-slide-items');
    if(!$container.length) return;
    df_slider($container, {
        effect: 'fade',
        autoplay: {
            delay: 4500,
        },
        speed: 400,
        df: {
            navigation: {
                use: true,
                addClass: 'df-content-wrap df-slider-nav-hover-on df-slider-nav-size-big df-slider-nav-shape-box df-slider-nav-color-gray',
            },
            autoPlay: true,
            autoplayHover: true,
        },
    });
})();


/* 상세페이지 구매가이드 탭 */
(function(){
    var $container = $DF('.detail-guide');
    if(!$container.length) return;
	var $title = $container.find('.df-tab-item');
    var $content = $container.find('.df-tab-content');
    $title.on('click', function(){
        var $this = $DF(this);
        $this.addClass('active').siblings().removeClass('active');
        $content.eq($this.index()).addClass('active').siblings().removeClass('active');
    });
})();



/*-----------------------------------------------------------------
  210319 디자인개편 BY DFLOOR PDG
-----------------------------------------------------------------*/
/* 게시판 nav1 selected 클래스 삽입 */
function df_getBoardNo(str){
	var cateno = df_getParam(str)['board_no'];
	if(cateno==undefined){
		var url = window.location.pathname.split('/');
		if(url[1]=='board')
			cateno = url[3];
	}
	return cateno;
}
(function(){
    var $container = $DF('#df-board-nav1');
    if(!$container.length) return;
    var no = df_getBoardNo(location.search);
    $container.children('[data-board-no="'+no+'"]').addClass('selected');
})();

/* 메인 슬라이드2 좌우 배너 */
(function(){
	var $container = $DF('.df-slide2-wrap');
	if(!$container.length) return;
	var $items = $container.find('.df-slide2-items');
	if(!$items.length) return;
    var $left_items = $items.find('.df-slide2left-items');
    var $right_items = $items.find('.df-slide2right-items');
	df_slider($left_items, {
		slidesPerView: 1,
		slidesPerGroup: 1,
		spaceBetween: 0,
		autoHeight: false,
		autoplay: {
			delay: 4500,
		},
		speed: 500,
		df: {
            navigation: {
                use: true,
                addClass: 'df-slider-nav-hover-on df-slider-nav-size-big df-slider-nav-shape-box df-slider-nav-color-gray',
            },
			pagination: {
				use: true,
				type: 'circle',
			},
			autoPlay: true,
			autoplayHover: true,
		},
	});
    df_slider($right_items, {
		slidesPerView: 1,
		slidesPerGroup: 1,
		spaceBetween: 0,
		autoHeight: false,
		autoplay: {
			delay: 4500,
		},
		speed: 500,
		df: {
            navigation: {
                use: true,
                addClass: 'df-slider-nav-hover-on df-slider-nav-size-big df-slider-nav-shape-box df-slider-nav-color-gray',
            },
			pagination: {
				use: true,
				type: 'circle',
			},
			autoPlay: true,
			autoplayHover: true,
		},
	});
})();

/* 메인 4단 슬라이드 배너 */
(function(){
	var $container = $DF('.df-quadslide-wrap');
	if(!$container.length) return;
	var $items = $container.find('.df-quadslide-items');
	if(!$items.length) return;
	df_slider($items, {
		slidesPerView: 4,
		slidesPerGroup: 4,
		spaceBetween: 20,
		autoHeight: false,
		autoplay: {
			delay: 4500,
		},
		speed: 500,
		df: {
			navigation: {
				use: true,
				addClass: '',
			},
			autoPlay: true,
			autoplayHover: true,
		},
	});
})();

/* 메인 탭 슬라이드 상품진열 */
(function(){
	var $container = $DF('.df-tabslide-wrap');
	if(!$container.length) return;
	var $items = $container.find('.df-tabslide-items');
	if(!$items.length) return;
	$container.appendTo($DF('.df-tabslide-area'));
	var $item = $items.find('.df-tabslide-item');
	for(var i=0; i<$item.length; i++){
		var $el = $item.eq(i);
		$el.attr('data-title', $el.find('.df-prl-data-title').text());
	}
	df_slider($items, {
		slidesPerView: 1,
		slidesPerGroup: 1,
		spaceBetween: 20,
		autoHeight: false,
		autoplay: {
			delay: 4500,
		},
		speed: 500,
		df: {
			pagination: {
				use: true,
				type: 'text',
			},
			autoPlay: false,
			autoplayHover: false,
		},
	});
	$container.find('.swiper-container').before($container.find('.swiper-pagination'));
	$container.find('.df-prl-wrap').css('opacity', 1);
})();



/*-----------------------------------------------------------------
  디자인개편 231108 BY DFLOOR PDG (위 기존 개편내용에서 다수 수정)
-----------------------------------------------------------------*/
(function(){    
    var $container = $DF('.df-tsbn-wrap_mainslide, .df-tsbn-wrap_banner');
    if(!$container.length) return;
    var setTimeDom = function($item){
        $item.each(function(index){
            var $el = $item.eq(index);
            $el.append(`
                <div class="df-tsbn-container">
                    <div class="df-tsbn-con_t1"></div>
                    <div class="df-tsbn-con_d"></div>
                    <div class="df-tsbn-con_t2">일</div>
                    <div class="df-tsbn-con_h"></div>
                    <div class="df-tsbn-con_t3">:</div>
                    <div class="df-tsbn-con_m"></div>
                    <div class="df-tsbn-con_t4">:</div>
                    <div class="df-tsbn-con_s"></div>
                </div>
            `);
			setTimeCount($el);
        });
    }
    var setTimeCount = function($item){
        var endTimeText = $item.find('timesale').text();
        var endTime_arr = endTimeText.match(/^(\d+)-(\d+)-(\d+) (\d+)\:(\d+):(\d+)$/);
        var endTime = new Date(endTime_arr[1], endTime_arr[2]-1, endTime_arr[3], endTime_arr[4], endTime_arr[5], endTime_arr[6]).getTime();
        var $d = $item.find('.df-tsbn-con_d');
        var $h = $item.find('.df-tsbn-con_h');
        var $m = $item.find('.df-tsbn-con_m');
        var $s = $item.find('.df-tsbn-con_s');
        function addZeroVal(val){
            return String(val<10?'0'+val:val);
        }
        var putCount = function(val){
            if(val<0){
                $d.text('--');
                $h.text('--');
                $m.text('--');
                $s.text('--');
            }else{
                var d = addZeroVal(Math.floor(val / (1000 * 60 * 60 * 24)));
                var h = addZeroVal(Math.floor((val % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)));
                var m = addZeroVal(Math.floor((val % (1000 * 60 * 60)) / (1000 * 60)));
                var s = addZeroVal(Math.floor((val % (1000 * 60)) / 1000));
                $d.text(d);
                $h.text(h);
                $m.text(m);
                $s.text(s);
            }
        }
        var date = new Date().getTime() + 1000;
        var val = endTime-date;
        putCount(val);
        setInterval(function(){
            var date = new Date().getTime() + 1000;
            var val = endTime-date;
            putCount(val);
        }, 1000);
    }
    var $item, time;
    if($container.hasClass('df-tsbn-wrap_mainslide')){
        $item = $container.find('timesale').parents('a');
        setTimeDom($item);
    }else if($container.hasClass('df-tsbn-wrap_banner')){
        for(var i=1; i<=DF['set-tsbncate-no'].length; i++){
            if(df_getCateNo(location.search)==DF['set-tsbncate-no'][i]){
                $item = $container;
                $item.append('<timesale>'+DF['set-tsbncate-time'][i]+'</timesale>');
                setTimeDom($item);
                break;
            }
        }
    }else{
        return;
    }
})();








$(function(){
    if (typeof(EC_SHOP_MULTISHOP_SHIPPING) != "undefined") {
        var sShippingCountryCode4Cookie = 'shippingCountryCode';
        var bShippingCountryProc = false;

        // 배송국가 선택 설정이 사용안함이면 숨김
        if (EC_SHOP_MULTISHOP_SHIPPING.bMultishopShippingCountrySelection === false) {
            $('.xans-layout-multishopshipping .xans-layout-multishopshippingcountrylist').hide();
            $('.xans-layout-multishoplist .xans-layout-multishoplistmultioption .xans-layout-multishoplistmultioptioncountry').hide();
        } else {
            $('.thumb .xans-layout-multishoplistitem').hide();
            var aShippingCountryCode = document.cookie.match('(^|;) ?'+sShippingCountryCode4Cookie+'=([^;]*)(;|$)');
            if (typeof(aShippingCountryCode) != 'undefined' && aShippingCountryCode != null && aShippingCountryCode.length > 2) {
                var sShippingCountryValue = aShippingCountryCode[2];
            }

            // query string으로 넘어 온 배송국가 값이 있다면, 그 값을 적용함
            var aHrefCountryValue = decodeURIComponent(location.href).split("/?country=");

            if (aHrefCountryValue.length == 2) {
                var sShippingCountryValue = aHrefCountryValue[1];
            }

            // 메인 페이지에서 국가선택을 안한 경우, 그 외의 페이지에서 셋팅된 값이 안 나오는 현상 처리
            if (location.href.split("/").length != 4 && $(".xans-layout-multishopshipping .xans-layout-multishopshippingcountrylist").val()) {
                $(".xans-layout-multishoplist .xans-layout-multishoplistmultioption a .ship span").text(" : "+$(".xans-layout-multishopshipping .xans-layout-multishopshippingcountrylist option:selected").text().split("SHIPPING TO : ").join(""));

                if ($("#f_country").length > 0 && location.href.indexOf("orderform.html") > -1) {
                    $("#f_country").val($(".xans-layout-multishopshipping .xans-layout-multishopshippingcountrylist").val());
                }
            }
            if (typeof(sShippingCountryValue) != "undefined" && sShippingCountryValue != "" && sShippingCountryValue != null) {
                sShippingCountryValue = sShippingCountryValue.split("#")[0];
                var bShippingCountryProc = true;

                $(".xans-layout-multishopshipping .xans-layout-multishopshippingcountrylist").val(sShippingCountryValue);
                $(".xans-layout-multishoplist .xans-layout-multishoplistmultioption a .ship span").text(" : "+$(".xans-layout-multishopshipping .xans-layout-multishopshippingcountrylist option:selected").text().split("SHIPPING TO : ").join(""));
                var expires = new Date();
                expires.setTime(expires.getTime() + (30 * 24 * 60 * 60 * 1000)); // 30일간 쿠키 유지
                document.cookie = sShippingCountryCode4Cookie+'=' + $(".xans-layout-multishopshipping .xans-layout-multishopshippingcountrylist").val() +';path=/'+ ';expires=' + expires.toUTCString();
                if ($("#f_country").length > 0 && location.href.indexOf("orderform.html") > -1) {
                    $("#f_country").val(sShippingCountryValue).change();
                }
            }
        }
        // 언어선택 설정이 사용안함이면 숨김
        if (EC_SHOP_MULTISHOP_SHIPPING.bMultishopShippingLanguageSelection === false) {
            $('.xans-layout-multishopshipping .xans-layout-multishopshippinglanguagelist').hide();
            $('.xans-layout-multishoplist .xans-layout-multishoplistmultioption .xans-layout-multishoplistmultioptionlanguage').hide();
        } else {
            $('.thumb .xans-layout-multishoplistitem').hide();
        }

        // 배송국가 및 언어 설정이 둘 다 사용안함이면 숨김
        if (EC_SHOP_MULTISHOP_SHIPPING.bMultishopShipping === false) {
            $(".xans-layout-multishopshipping").hide();
            $('.xans-layout-multishoplist .xans-layout-multishoplistmultioption').hide();
        } else if (bShippingCountryProc === false && location.href.split("/").length == 4) { // 배송국가 값을 처리한 적이 없고, 메인화면일 때만 선택 레이어를 띄움
            var sShippingCountryValue = $(".xans-layout-multishopshipping .xans-layout-multishopshippingcountrylist").val();
            $(".xans-layout-multishopshipping .xans-layout-multishopshippingcountrylist").val(sShippingCountryValue);
            $(".xans-layout-multishoplist .xans-layout-multishoplistmultioption a .ship span").text(" : "+$(".xans-layout-multishopshipping .xans-layout-multishopshippingcountrylist option:selected").text().split("SHIPPING TO : ").join(""));
            // 배송국가 선택을 사용해야 레이어를 보이게 함
            if (EC_SHOP_MULTISHOP_SHIPPING.bMultishopShippingCountrySelection === true) {
                $(".xans-layout-multishopshipping").show();
            }
        }

        $(".xans-layout-multishopshipping .close").on("click", function() {
            $(".xans-layout-multishopshipping").hide();
        });

        $(".xans-layout-multishopshipping .ec-base-button a").on("click", function() {
            var expires = new Date();
            expires.setTime(expires.getTime() + (30 * 24 * 60 * 60 * 1000)); // 30일간 쿠키 유지
            document.cookie = sShippingCountryCode4Cookie+'=' + $(".xans-layout-multishopshipping .xans-layout-multishopshippingcountrylist").val() +';path=/'+ ';expires=' + expires.toUTCString();

            // 도메인 문제로 쿠키로 배송국가 설정이 안 되는 경우를 위해 query string으로 배송국가 값을 넘김
            var sQuerySting = (EC_SHOP_MULTISHOP_SHIPPING.bMultishopShippingCountrySelection === false) ? "" : "/?country="+encodeURIComponent($(".xans-layout-multishopshipping .xans-layout-multishopshippingcountrylist").val());

            location.href = '//'+$(".xans-layout-multishopshipping .xans-layout-multishopshippinglanguagelist").val()+sQuerySting;
        });
        $(".xans-layout-multishoplist .xans-layout-multishoplistmultioption a").on("click", function() {
            $(".xans-layout-multishopshipping").show();
        });
    }
});
/**
	======================================================================================================

        D E S I G N F L O O R

		이 쇼핑몰은 디자인플로어 서비스를 이용하고 있습니다.

        [대표전화] 1544-4941
        [홈페이지] www.dfloor.co.kr
        [특허청출원번호] 4120150030498

        디자인의 모든 저작권은 디자인플로어에 있으며, 1Copy 라이선스로 최초 적용된 쇼핑몰에서만 사용권을
        부여합니다. 디자인플로어 콘텐츠의 모든 라이선스는 아래의 '법적 고지'를 따릅니다.

	======================================================================================================

		※디자인플로어 라이선스 법적 고지※

		-본 사이트에 존재하는 모든 기술적 소스코드의 저작권은 오직 디자인플로어에 있습니다.
		-본 사이트에 존재하는 기술적 소스코드를 사용할 경우와 이를 변형하여 활용하는 경우
		 저작권법에 의거 법적 고지를 위반하는 것으로 판단하며 즉각 민형사상의 조치를 취합니다.
		-디자인플로어는 디자인의 개발·생산 및 콘텐츠의 보호를 가장 우선으로 하므로 진행되는
		 민형사소송건에 대한 합의는 진행하지 않는 점을 고지합니다.
		-디자인플로어는 민가율 합동 법률사무소 '김석호 변호사'와 함께 지적재산권을 수호하며
		 자문을 받고 있습니다.

	======================================================================================================
**/
/**
	업데이트: 2020-12-06
**/


!function(){var e,n,t,a,d=$DF(".df-topbanner");d.length&&1!=$DF.cookie("df-topbanner")&&(2<=(e=d.show().find(".df-topbanner-items")).children(".df-topbanner-item").length&&d.find(".df-topbanner-btn").addClass("df-topbanner-btn_space"),n=df_slider(e,{loop:!0,autoplay:{delay:4500},effect:"fade",speed:350,df:{navigation:{use:!0,addClass:"df-content-wrap df-slider-nav-hover-on df-slider-nav-size-small df-slider-nav-shape-circle df-slider-nav-color-white"},pagination:{use:!0,type:"circle+wide"},autoPlay:!0,autoplayHover:!0}}),t=d.find(".df-topbanner-btn-check"),a=d.find(".df-topbanner-btn-close"),t.on("click",function(){t.toggleClass("df-topbanner-btn-check_selected")}),a.on("click",function(){var e;1==t.hasClass("df-topbanner-btn-check_selected")&&((e=new Date).setDate(e.getDate()+1),$DF.cookie("df-topbanner",1,{expires:e,path:"/"})),d.animate({"margin-top":-d.height()},350,"easeinout",function(){d.hide(),void 0!==n[0]&&n[0].destroy(!0,!0)})}))}();

/**
	======================================================================================================

        D E S I G N F L O O R

		이 쇼핑몰은 디자인플로어 서비스를 이용하고 있습니다.

        [대표전화] 1544-4941
        [홈페이지] www.dfloor.co.kr
        [특허청출원번호] 4120150030498

        디자인의 모든 저작권은 디자인플로어에 있으며, 1Copy 라이선스로 최초 적용된 쇼핑몰에서만 사용권을
        부여합니다. 디자인플로어 콘텐츠의 모든 라이선스는 아래의 '법적 고지'를 따릅니다.

	======================================================================================================

		※디자인플로어 라이선스 법적 고지※

		-본 사이트에 존재하는 모든 기술적 소스코드의 저작권은 오직 디자인플로어에 있습니다.
		-본 사이트에 존재하는 기술적 소스코드를 사용할 경우와 이를 변형하여 활용하는 경우
		 저작권법에 의거 법적 고지를 위반하는 것으로 판단하며 즉각 민형사상의 조치를 취합니다.
		-디자인플로어는 디자인의 개발·생산 및 콘텐츠의 보호를 가장 우선으로 하므로 진행되는
		 민형사소송건에 대한 합의는 진행하지 않는 점을 고지합니다.
		-디자인플로어는 민가율 합동 법률사무소 '김석호 변호사'와 함께 지적재산권을 수호하며
		 자문을 받고 있습니다.

	======================================================================================================
**/
/**
	업데이트: 2023-08-20
**/


(function(){$DF.dffixbanner=function(a,b){var c,d,e,f,g,h,i={use:!0,slide:{use:!0,useBtn:!0,useCookie:!0,firstState:!0,classes:{useCheckLength:".df-bannermanager",slideBtn:".onoff",setSlideOn:"on"}},ajax:{useCount:!0,classes:{area:".fxax",count:".count",content:".content",close:".close",loaded:"loaded",selected:"selected"},areaHtml:"<div class=\"fxax\"><div class=\"loading\"><i class=\"xi-spinner-5 xi-spin loading-icon\"></i></div></div>",fileNameAttr:"df-data-ajaxname",fileQueryAttr:"df-data-query",areaFadeInSpeed:50,contentFadeInSpeed:120,areaFadeOutSpeed:50},scroll:{use:!0,classes:{area:".updown",up:".up",down:".down"},speed:1e3,ease:"easeInOutCubic"},initBefore:function(){return!0},initAfter:function(){return!0}},j={},k=$DF(a);j.init=function(){if(c=j.settings=$DF.extend(!0,i,b),"undefined"!=typeof setSize){if(c.initBefore.call(j,k),!1===c.use)return!1;if(!0===c.scroll.use&&(f=k.find(c.scroll.classes.area),g=f.find(c.scroll.classes.up),h=f.find(c.scroll.classes.down),f.show(),g.on("click",function(){return $DF("html, body").stop().animate({scrollTop:0},c.scroll.speed,c.scroll.ease),!1}),h.on("click",function(){return $DF("html, body").stop().animate({scrollTop:$DF(document).height()-$DF(window).height()},c.scroll.speed,c.scroll.ease),!1})),!0===c.slide.use&&0<k.find(c.slide.classes.useCheckLength).length){if(!0===c.slide.useCookie){var a=$DF.cookie("dffixbanner");1==a?k.addClass(c.slide.classes.setSlideOn):"undefined"==typeof a&&!0===c.slide.firstState&&k.addClass(c.slide.classes.setSlideOn)}else!0===c.slide.firstState&&k.addClass(c.slide.classes.setSlideOn);!0===c.slide.useBtn&&(d=k.find(c.slide.classes.slideBtn),d.show(),d.on("click",function(){k.toggleClass(c.slide.classes.setSlideOn),!0===c.slide.useCookie&&(!0===k.hasClass(c.slide.classes.setSlideOn)?$DF.cookie("dffixbanner",1,{expires:1,path:"/",secure:!1}):$DF.cookie("dffixbanner",0,{expires:1,path:"/",secure:!1}))}))}e=k.find(".ajax-call"),!0===c.ajax.useCount&&e.find(".count").each(function(){var a=$DF(this);"0"==a.text()&&a.hide();const b={childList:!0,subtree:!0,characterData:!0},c=new MutationObserver(b=>{for(const c of b)("childList"===c.type||"characterData"===c.type)&&0<parseInt(a.text())&&(a.show(),a.off("DOMSubtreeModified propertychange"))});for(var d=0;d<a.length;d++)c.observe(a[0],b)}),e.children("a").on("click",function(){var a=$DF(this).parent();if(a.toggleClass(c.ajax.classes.selected).siblings().removeClass(c.ajax.classes.selected),!0===a.hasClass(c.ajax.classes.selected)){var b=a.append(c.ajax.areaHtml).find(c.ajax.classes.area).fadeIn(c.ajax.areaFadeInSpeed);$DF.ajax({url:"/dfloor/plugin/df-fixbanner/ajax."+a.attr(c.ajax.fileNameAttr)+".html"+(null==a.attr(c.ajax.fileQueryAttr)?"":a.attr(c.ajax.fileQueryAttr)),dataType:"html",success:function(a){b.append($DF(a).filter(c.ajax.classes.content)[0].outerHTML).addClass(c.ajax.classes.loaded),b.find(c.ajax.classes.content).fadeIn(c.ajax.contentFadeInSpeed,function(){$DF(this).find(".scrollbar-macosx").scrollbar()}),b.find(c.ajax.classes.close).one("click",function(){b.fadeOut(c.ajax.areaFadeOutSpeed,function(){e.removeClass(c.ajax.classes.selected)})})}}).done(function(){}),a.siblings().find(c.ajax.classes.area).fadeOut(c.ajax.areaFadeOutSpeed,function(){$DF(this).remove()})}else e.find(c.ajax.classes.area).fadeOut(c.ajax.areaFadeOutSpeed,function(){$DF(this).remove()})}),c.initAfter.call(j,k),k.show()}},j.init()},$DF.fn.dffixbanner=function(a){return this.each(function(){if("undefined"!=typeof setSize){var b=$DF(this),c=b.data("dffixbanner");return c?c.methods[a]?c.methods[a].apply(this,Array.prototype.slice.call(arguments,1)):void 0:(c=new $DF.dffixbanner(this,a),b.data("dffixbanner",c),c)}})},$DF(".df-fixbanner").dffixbanner({use:!0,slide:{use:!0,useBtn:!0,useCookie:!0,firstState:!1,classes:{useCheckLength:"img",slideBtn:".onoff",setSlideOn:"fxb-open"}},ajax:{useCount:!0,classes:{area:".fxb-ajax-wrap",count:".count",content:".content",close:".btn-close",loaded:"loaded",selected:"selected"},areaHtml:"<div class=\"fxb-ajax-wrap\"><div class=\"loading\"><i class=\"xi-spinner-5 xi-spin loading-icon\"></i></div></div>",fileNameAttr:"df-data-ajaxname",fileQueryAttr:"df-data-query",areaFadeInSpeed:50,contentFadeInSpeed:120,areaFadeOutSpeed:50},scroll:{use:!0,classes:{area:".updown",up:".up",down:".down"},speed:1e3,ease:"easeInOutCubic"},initAfter:function(a){a.css("display","flex")}}),$DF(".df-snsicon-wrap").each(function(){var a=!1;$DF(this).find(".df-snsicon-item").each(function(){"none"!=$DF(this).css("display")&&(a=!0)}),!0==a&&$DF(this).show()}),$DF(".df-fixbanner").each(function(){var a=$DF(this);df_slider(a.find(".fxb-slide"),{loop:!0,autoplay:{delay:5e3},speed:700,df:{navigation:{use:!0,addClass:"df-slider-nav-hover-on df-slider-nav-size-small df-slider-nav-shape-box df-slider-nav-color-gray"},pagination:{use:!0,type:"stick+wide"},autoPlay:!0,autoplayHover:!0}})})})();

/**
	======================================================================================================

        D E S I G N F L O O R

		이 쇼핑몰은 디자인플로어 서비스를 이용하고 있습니다.

        [대표전화] 1544-4941
        [홈페이지] www.dfloor.co.kr
        [특허청출원번호] 4120150030498

        디자인의 모든 저작권은 디자인플로어에 있으며, 1Copy 라이선스로 최초 적용된 쇼핑몰에서만 사용권을
        부여합니다. 디자인플로어 콘텐츠의 모든 라이선스는 아래의 '법적 고지'를 따릅니다.

	======================================================================================================

		※디자인플로어 라이선스 법적 고지※

		-본 사이트에 존재하는 모든 기술적 소스코드의 저작권은 오직 디자인플로어에 있습니다.
		-본 사이트에 존재하는 기술적 소스코드를 사용할 경우와 이를 변형하여 활용하는 경우
		 저작권법에 의거 법적 고지를 위반하는 것으로 판단하며 즉각 민형사상의 조치를 취합니다.
		-디자인플로어는 디자인의 개발·생산 및 콘텐츠의 보호를 가장 우선으로 하므로 진행되는
		 민형사소송건에 대한 합의는 진행하지 않는 점을 고지합니다.
		-디자인플로어는 민가율 합동 법률사무소 '김석호 변호사'와 함께 지적재산권을 수호하며
		 자문을 받고 있습니다.

	======================================================================================================
**/
/**
	업데이트: 2022-06-20
**/


!function(){var o,i,a,d=$DF(".df-intropopup");d.length&&1!=$DF.cookie("df-intropopup")&&(d.show().css({display:"block"}),o=d.find(".df-intropopup-box"),i={loop:!0,effect:"fade",autoplay:{delay:5e3},speed:700,df:{navigation:{use:!0,addClass:"df-slider-nav-hover-on df-slider-nav-size-big df-slider-nav-shape-box df-slider-nav-color-black"},pagination:{use:!0,type:"timer"},autoPlay:!0,autoplayHover:!0}},$DF("html").hasClass("df-native-mobile")&&(i.df.autoplayHover=!1,i.df.navigation.addClass="df-slider-nav-size-big df-slider-nav-shape-box df-slider-nav-color-black"),a=df_slider(o.children("ul"),i),d.find(".df-intropopup-btn-item_todayclose").on("click",function(){$DF.cookie("df-intropopup",1,{path:"/",expires:1}),d.hide(),void 0!==a[0]&&a[0].destroy(!0,!0)}),d.on("click",function(o){o=$DF(o.target);(o.hasClass("df-intropopup-btn-item_close")||o.hasClass("df-intropopup-btn-close_l1")||o.hasClass("df-intropopup-btn-close_l2")||o.hasClass("df-intropopup"))&&(d.hide(),void 0!==a[0]&&a[0].destroy(!0,!0))}))}();

/**
	======================================================================================================

        D E S I G N F L O O R

		이 쇼핑몰은 디자인플로어 서비스를 이용하고 있습니다.

        [대표전화] 1544-4941
        [홈페이지] www.dfloor.co.kr
        [특허청출원번호] 4120150030498

        디자인의 모든 저작권은 디자인플로어에 있으며, 1Copy 라이선스로 최초 적용된 쇼핑몰에서만 사용권을
        부여합니다. 디자인플로어 콘텐츠의 모든 라이선스는 아래의 '법적 고지'를 따릅니다.

	======================================================================================================

		※디자인플로어 라이선스 법적 고지※

		-본 사이트에 존재하는 모든 기술적 소스코드의 저작권은 오직 디자인플로어에 있습니다.
		-본 사이트에 존재하는 기술적 소스코드를 사용할 경우와 이를 변형하여 활용하는 경우
		 저작권법에 의거 법적 고지를 위반하는 것으로 판단하며 즉각 민형사상의 조치를 취합니다.
		-디자인플로어는 디자인의 개발·생산 및 콘텐츠의 보호를 가장 우선으로 하므로 진행되는
		 민형사소송건에 대한 합의는 진행하지 않는 점을 고지합니다.
		-디자인플로어는 민가율 합동 법률사무소 '김석호 변호사'와 함께 지적재산권을 수호하며
		 자문을 받고 있습니다.

	======================================================================================================
**/
/**
	업데이트: 2020-12-06
**/


!function(){var i=$DF(".df-multipopup");if(i.length&&1!=$DF.cookie("df-multipopup")){i.show().css({top:DF["set-multipopup-top"]+"px",left:DF["set-multipopup-left"]+"px",display:"block"});var t=i.find(".df-multipopup-box"),e=df_slider(t.children("ul"),{df:{pagination:{use:!0,type:"text"},autoPlay:!0,autoplayHover:!0}});i.find(".swiper-pagination-item").on("mouseenter",function(){$DF(this).trigger("click")});for(var o=t.find(".swiper-slide").not(".swiper-slide-duplicate-active"),n=i.find(".swiper-pagination-item-link"),p=0;p<o.length;p++)"#none"==o.eq(p).children("a").attr("href")&&n.eq(p).addClass("cursornone");n.on("click",function(i){var t=$DF(this);o.eq(t.parents(".swiper-pagination-item").index()).find("a").get(0).click()}),i.find(".df-multipopup-btn-item_todayclose").on("click",function(){$DF.cookie("df-multipopup",1,{path:"/",expires:1}),i.hide(),void 0!==e[0]&&e[0].destroy(!0,!0)}),i.find(".df-multipopup-btn-item_close").on("click",function(){i.hide(),void 0!==e[0]&&e[0].destroy(!0,!0)})}}();

/**
	======================================================================================================

        D E S I G N F L O O R

		이 쇼핑몰은 디자인플로어 서비스를 이용하고 있습니다.

        [대표전화] 1544-4941
        [홈페이지] www.dfloor.co.kr
        [특허청출원번호] 4120150030498

        디자인의 모든 저작권은 디자인플로어에 있으며, 1Copy 라이선스로 최초 적용된 쇼핑몰에서만 사용권을
        부여합니다. 디자인플로어 콘텐츠의 모든 라이선스는 아래의 '법적 고지'를 따릅니다.

	======================================================================================================

		※디자인플로어 라이선스 법적 고지※

		-본 사이트에 존재하는 모든 기술적 소스코드의 저작권은 오직 디자인플로어에 있습니다.
		-본 사이트에 존재하는 기술적 소스코드를 사용할 경우와 이를 변형하여 활용하는 경우
		 저작권법에 의거 법적 고지를 위반하는 것으로 판단하며 즉각 민형사상의 조치를 취합니다.
		-디자인플로어는 디자인의 개발·생산 및 콘텐츠의 보호를 가장 우선으로 하므로 진행되는
		 민형사소송건에 대한 합의는 진행하지 않는 점을 고지합니다.
		-디자인플로어는 민가율 합동 법률사무소 '김석호 변호사'와 함께 지적재산권을 수호하며
		 자문을 받고 있습니다.

	======================================================================================================
**/
/**
	업데이트: 2021-09-23
	-특정상황 충돌예방 var plugin = this; → var plugin = {}; 2021-09-23
**/


$DF.dfmainlist=function(e,i){var t,o,n,s,a,d={responsive:!0,axis:"y",classes:{findList:".xans-product-listmain",moveList:".df-movelist"},scrollSpeed:600,scrollEase:"easeInOutQuart",scrollMarginTop:120,autoHide:!0,autoHideType:"fade",autoHideDelay:3e3,autoHideSpeed:200,moveBox:{use:!0,marginLeft:4,marginTop:0,speed:200,ease:"easeInOutQuart"},initBefore:function(){return!0},initAfter:function(){return!0}},l={},f=$DF(e),u=0,r=[],c=[],m=0,p=0,v=0,x=[],h=!1,F=null;l.init=function(){t=l.settings=$DF.extend({},d,i),"undefined"!=typeof setSize&&(t.initBefore.call(l,f),o=f.find(t.classes.findList),(n=f.find(t.classes.moveList)).addClass("df-movelist-axis-"+t.axis),x.push("<ul>"),o.each(function(){var e=$DF(this),i='<a href="#none" class="df-movelist-link">'+e.find("h2").html()+"</a>";""==e.find("h2").text()&&(i=e.find(".imgtitle")[0].outerHTML),x.push('<li class="df-movelist-item">'+i+"</li>")}),x.push("</ul>"),1==t.moveBox.use&&x.push('<div class="df-movelist-movebox"></div>'),n.find("div").append(x.join("")),s=n.find("li"),v=s.length,l.getPosition(),1==t.responsive&&$DF(window).on("resize",function(){l.getPosition()}),1==t.autoHide?l.autoHide():n.show(),$DF(document).on("scroll",function(){l.scrollAct()}),n.find("li").on("click",function(){var e=$DF(this);l.getPosition(),$DF("html, body").stop().animate({scrollTop:r[e.index()]-t.scrollMarginTop},t.scrollSpeed,t.scrollEase)}),n.find("a").click(function(e){e.preventDefault()}),t.initAfter.call(l,f))},l.getPosition=function(){u=$DF(window).height(),o.each(function(e){var i=$DF(this);r[e]=i.offset().top,c[e]=r[e]+i.outerHeight()}),m=r[0]-u,p=c[v-1]-t.scrollMarginTop},l.scrollAct=function(){var e=$DF(document).scrollTop();1==t.autoHide?m<=e&&e<p?(l.autoHideFadeIn(),l.scrollActs(e)):l.autoHideFadeOut():l.scrollActs(e)},l.scrollActs=function(e){for(var i=0;i<v;i++)if(r[i]-u/3<=e&&c[i]-u/3>e&&(F!=i||null==F))return F=i,s.eq(i).addClass("df-movelist-item_on").siblings().removeClass("df-movelist-item_on"),1==t.moveBox.use&&("y"==t.axis?n.find(".df-movelist-movebox").stop().fadeIn(t.moveBox.speed).animate({top:s.eq(i).offset().top-s.eq(0).offset().top+(0!=i?t.moveBox.marginTop:0)},t.moveBox.speed):"x"==t.axis&&n.find(".df-movelist-movebox").stop().fadeIn(t.moveBox.speed).animate({left:s.eq(i).offset().left-s.eq(0).offset().left+(0!=i?t.moveBox.marginLeft:0),width:s.eq(i).find("a").outerWidth()},t.moveBox.speed,t.moveBox.ease)),!1},l.autoHide=function(){n.on({mouseenter:function(){clearTimeout(a),n.fadeIn(t.autoHideSpeed,function(){h=!0})},mouseleave:function(){h=!1,l.autoHideFadeIn()}})},l.autoHideFadeIn=function(){n.fadeIn(t.autoHideSpeed,function(){clearTimeout(a),0==h&&(a=setTimeout(l.autoHideFadeOut,t.autoHideDelay))})},l.autoHideFadeOut=function(){n.fadeOut(t.autoHideSpeed,function(){clearTimeout(a)})},l.init()},$DF.fn.dfmainlist=function(t){return this.each(function(){if("undefined"!=typeof setSize){var e=$DF(this),i=e.data("dfmainlist");return i?i.methods[t]?i.methods[t].apply(this,Array.prototype.slice.call(arguments,1)):void 0:(i=new $DF.dfmainlist(this,t),e.data("dfmainlist",i),i)}})},1<$DF(".df-wrap-main").find(".xans-product-listmain").length&&"on"==DF["set-movelist"]&&$DF(".df-wrap-main").dfmainlist({responsive:!0,axis:null==DF["set-movelist-axis"]?"x":DF["set-movelist-axis"],classes:{findList:".xans-product-listmain, .df-add-mainlist"+("on"==DF["set-review-mainuse"]?", .df-review-main":""),moveList:".df-movelist"},scrollSpeed:600,scrollEase:"easeInOutQuart",scrollMarginTop:120,autoHide:!0,autoHideType:"fade",autoHideDelay:3e3,autoHideSpeed:200,moveBox:{use:!0,marginLeft:4,marginTop:0,speed:200,ease:"easeInOutQuart"}});

