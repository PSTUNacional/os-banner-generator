function adjustFontSize(id, min, max) {
    console.log('Adjust font-size for: '+id)
    el = document.getElementById(id)
    currentHeight = el.offsetHeight
    currentFontSize = parseInt(window.getComputedStyle(el, null).getPropertyValue('font-size'))

    while (currentHeight < min) {
        currentFontSize += 8
        el.style.fontSize = currentFontSize + 'px'
        currentHeight = el.offsetHeight
        currentFontSize = parseInt(window.getComputedStyle(el, null).getPropertyValue('font-size'))
    }

    while (currentHeight > max) {
        currentFontSize -= 8
        if (currentFontSize < 8) { currentFontSize = 8 } // Define minimum font-size
        el.style.fontSize = currentFontSize + 'px'
        currentHeight = el.offsetHeight
        currentFontSize = parseInt(window.getComputedStyle(el, null).getPropertyValue('font-size'))
    }
}

function createImage() {
    html2canvas(document.querySelector("#canvas"), {
        allowTaint: true,
        useCORS: true
    })
        .then(canvas => {
            document.body.appendChild(canvas)
        })
        .then(()=>{
            var img = document.querySelector('canvas').toDataURL()
            var content = new FormData()
            content.append('data', img)
            content.append('id', id)
            content.append('mat_link', link)
            content.append('mat_title', title)
            content.append('author', 'Automation')
            content.append('format', format)
            
            fetch('https://www.opiniaosocialista.com.br/automation/banners/src/Service/Register.php',{
                method: "POST",
                body: content
            })
        }); 
}


