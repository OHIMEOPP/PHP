function O(i) { return typeof i == 'object' ? i : document.getElementById(i) }
function S(i) { return O(i).style }
function C(i) { return document.getElementsByClassName(i) }

function sreach_drop(c_div, suggestions, searchInput, suggestionsDiv) {
    const ul = document.createElement('ul');
    c_div.innerHTML = "還沒有標籤喔~~";

    var s = showSuggestions(c_div, suggestions, searchInput, suggestionsDiv);

    function showSuggestions(c_div, suggestions, searchInput, suggestionsDiv) {
        c_div.innerHTML = "";
        suggestions.forEach(function (suggestion) {
            // c_div.innerHTML = "";
            const li = document.createElement('a');
            li.textContent = suggestion;
            li.addEventListener('click', function () {

                var currentValue = searchInput.value;
                if (currentValue !== "") {
                    currentValue += ",";
                }

                // 将按钮的文本内容添加到输入框中
                searchInput.value = currentValue + suggestion;
            });
            ul.appendChild(li);
        });
        suggestionsDiv.appendChild(ul);
        return "我很好fg";
    }

}
function setimg_formation(diswindowID) {
    var set_tag_m = document.getElementById(diswindowID);
    let isScrollDisabled = false;
    console.log("float_window");
    if (set_tag_m.style.display == "none") {
        set_tag_m.style.display = "flex";
        window.scrollBy(0, -10000);
        isScrollDisabled = !isScrollDisabled;
        document.body.classList.toggle('no-scroll', isScrollDisabled);

    } else {
        set_tag_m.style.display = "none";
        isScrollDisabled = false;
        document.body.classList.toggle('no-scroll', isScrollDisabled);
    }
}
function _dynamictagtype(searchInput, tag_type) {
    // console.log("dynum2");
    const taggroupline = document.getElementById("demo");
    if (tag_type) {
        taggroupline.textContent = "";
        tag_type.forEach(function (type) {
            console.log(type);
            const a = document.createElement("p");
            // a.href = "#";
            //當按下a時傳送post
            // a.onclick = function() {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "anothertypegroup.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

            xhr.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    a.textContent = type;
                    taggroupline.appendChild(a);
                    taggroupline.innerHTML += this.responseText;

                    asdd(searchInput,taggroupline);
                }
            };
            xhr.send("_type=" + type);
            // };
        });


    }

}
function f_w_dynamictagtype(tag_type) {
    // console.log("dynum2");
    const taggroupline = document.querySelector(".revise_tag_checktag");
    if (tag_type) {
        taggroupline.textContent = "";
        tag_type.forEach(function (type) {
            const p = document.createElement("p");
            // a.href = "#";
            //當按下a時傳送post
            // a.onclick = function() {

            var xhr = new XMLHttpRequest();
            xhr.open("POST", "anothertypegroup.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

            xhr.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    if(type != "人物" )
                        if(type != "團體" )
                            if(type != "作者" )
                    p.textContent = type;
                    
                    taggroupline.appendChild(p);
                    taggroupline.innerHTML += this.responseText;
                    // const oo = document.querySelectorAll(".revise_tag_checktag a");
                    // // console.log(oo);
                    // oo.forEach(o=>{
                    //     // console.log(o);
                    //     o.onclick = function(){
                    //         openedit(this.value)
                    //     }
                    // })
                    
                }
            };
            xhr.send("fw_type=" + type);
            // };
        });


    }

}
function asdd(searchInput,taggroupline) {
    document.querySelectorAll('#demo a').forEach(a => {
        a.addEventListener('click', function () {
            var currentValue = searchInput.value;
            if (currentValue !== "") {
                currentValue += ",";
            }

            // 将按钮的文本内容添加到输入框中
            searchInput.value = currentValue + a.textContent;

        });
    })
}
const float_window_input = document.querySelectorAll(".float_window input");
function fw_cancel_close() {
    // const checktagDiv = document.querySelector(".checktag");
    
    float_window_input.forEach(function(input) {
        input.value = "";
    });
    // checktagDiv.textContent = "";

    const float_window = document.querySelector(".float_window");


    let isScrollDisabled = false;
    if (float_window.style.display == "flex") {
        float_window.style.display = "none";
        isScrollDisabled = false;
        document.body.classList.toggle('no-scroll', isScrollDisabled);

    }
}
function fw_cancel() {
    // const checktagDiv = document.querySelector(".checktag");
    float_window_input.forEach(function(input) {
        input.value = "";
    });

}
function isUrl(string) {
    try {
      new URL(string);
      return true;
    } catch (err) {
      return false;
    }
  }