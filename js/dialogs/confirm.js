var mask,
    dialog;

function createMask() {
    mask = document.createElement('div')
    document.body.appendChild(mask)
    mask.style.background = 'rgba(0, 0, 0, 0.7)'
    mask.style.position = 'fixed'
    mask.style.top = '0px'
    mask.style.left = '0px'
    mask.style.width = '100%'
    mask.style.height = '100%'
    mask.style.zIndex = '99999'
}


// Shows confirm dialog
export default function(title, description) {
    dialog = document.createElement('div')
    dialog.style.border = '1px solid #FFF'
    dialog.style.color = '#333'
    dialog.style.padding = '13px'
    dialog.style.position = 'fixed'
    dialog.style.zIndex = '999999'
    dialog.style.background = 'rgba(255, 255, 255, 0.9)'
    dialog.style.width = '100%'
    dialog.style.maxWidth = '400px'
    dialog.style.top =  `${ window.innerHeight > 500 ? 200 : 5 }px`
    dialog.style.left =  `${ window.innerWidth > 400 ? ((window.innerWidth - 400) / 2) : 0 }px`
    dialog.innerHTML = `
        <h2>${title}</h2>
        <p>${description}</p>
        <br/>
        <div class="text-right">
            <button class="btn btn-raised btn-success" data-ref="ok">OK</button>
            <button class="btn btn-raised" data-ref="cancel">Cancelar</button>
        </div>
    `

    createMask()
    mask.appendChild(dialog)
    return new Promise((resolve) => {
        dialog.querySelector("[data-ref='ok']").addEventListener('click', () => {
            mask.parentElement.removeChild(mask)
            resolve(true)
        })

        dialog.querySelector("[data-ref='cancel']").addEventListener('click', () => {
            mask.parentElement.removeChild(mask)
            resolve(false)
        })
    })
}
