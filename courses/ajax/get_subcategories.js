function get_categories(id, cat) {
    var element = null;
    var isLoaded = [];
    if(element = document.getElementById(id)) {
        isLoaded = element.classList;
    }

    if (element == null) {
        return;
    }

    if (isLoaded.contains('loaded')) {
        isLoaded.remove('loaded');
        isLoaded.add('unloaded');
        document.getElementById(id + '-subs').remove();
        return null;
    }
    isLoaded.remove('unloaded');
    isLoaded.add('loaded');

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            var data = xmlhttp.responseText;

            if (data != false) {
                var dataJSON = JSON.parse(data);
                var parent = null;
                if(parent = document.getElementById(id)) {
                    var subCategories = document.createElement('dd');
                    subCategories.id = id + '-subs';
                    parent.after(subCategories);

                    for (let i = 0; i < dataJSON.length; i++) {
                        var dtTag = document.createElement('dt');
                        dtTag.id = 'category' + dataJSON[i][0];
                        dtTag.classList.add('category-link');
                        dtTag.classList.add('unloaded');
                        subCategories.appendChild(dtTag);

                        var link = document.createElement('button');
                        link.innerHTML = dataJSON[i][1];
                        dtTag.appendChild(link);
                        addClickListener(dtTag.id, dataJSON[i][0]);
                    }
                }
            }
            return;
        }
    }
    var params = 'catid='+cat;
    xmlhttp.open("POST", "ajax/get_course_categories.php", true);
    xmlhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xmlhttp.send(params);
}

function addClickListener(elementid, id) {
    document.getElementById(elementid).children[0].addEventListener('click',function() {get_categories(elementid, id)});
}