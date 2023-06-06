const listadoForm = document.getElementById('listadoForm');
listadoForm.children[1].remove();
const addReg = document.createElement('button');
addReg.innerHTML = 'Insertar Nuevo';

const updateForm = document.getElementById('updateForm');
updateForm.style.display = 'none';

const deleteForm = document.getElementById('deleteForm');
deleteForm.style.display = 'none';

const insertForm = document.getElementById('insertForm');
insertForm.style.display = 'none';


//// IMPORTANTE ESTA URL APUNTA A LA DIRECCION DE LA API ////
fetch('http://localhost/RestAPI/api.php')
    .then(consulta => consulta.json())
    .then(respuesta => mostrar(respuesta));

const ejecutar = (e) => {
    if (e.target.tagName == 'BUTTON') {
        let data = e.target.textContent == 'Editar' ? e.target.parentElement : e.target.parentElement.firstChild;
        const formularios = document.querySelectorAll('form');
        switch (data.tagName) {
            case 'TR':
                updateForm.style.display = 'block';
                deleteForm.style.display = 'none';
                insertForm.style.display = 'none';
                [...data.cells].forEach(item => {
                    formularios[0][item.cellIndex+1].value = item.textContent;
                })

                break;
            case 'TD':
                deleteForm.style.display = 'block';
                updateForm.style.display = 'none';
                insertForm.style.display = 'none';
                formularios[2][1].value = data.textContent;
                break
        }
    }

}

const mostrar = (datos) => {
    const headers = Object.keys(datos[0]);
    const container = document.querySelector('#listadoForm');
    let table = document.createElement('table');
    container.append(table);
    let tr = document.createElement('tr');
    table.append(tr);
    headers.forEach(item => {
        tr.innerHTML += `<th>${item}</th>`
    })
    datos.map(item => {
        let trtd = document.createElement('tr');
        table.append(trtd);
        headers.forEach(dato => {
            trtd.innerHTML += `<td>${item[dato]}</td>`;
        })
        trtd.innerHTML += '<button>Editar</button>';
        trtd.innerHTML += '<button>Borrar</button>';
    })

    table.addEventListener('click', ejecutar);
    listadoForm.appendChild(addReg);
    addReg.addEventListener('click', () => {
        insertForm.style.display = 'block';
        updateForm.style.display = 'none';
        deleteForm.style.display = 'none';
    })
}

