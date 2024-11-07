// Estilos CSS
const styles = `
body {
  background-color: #080202;
  color: #ffffff;
  font-family: Arial, sans-serif;
}

#popup-menu {
  display: none;
  position: fixed;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  background-color: #2a2a2a;
  padding: 20px;
  border: 2px solid #4a4a4a;
  border-radius: 10px;
  box-shadow: 0 0 20px rgba(255, 255, 255, 0.1);
  z-index: 1000;
  max-height: 80vh;
  overflow-y: auto;
  width: 90%;
}

#popup-menu h2 {
  color: #ffd700;
  text-align: center;
  margin-bottom: 20px;
}

#lista-productos {
  list-style-type: none;
  padding: 0;
}

#lista-productos li {
  background-color: #080202;
  margin-bottom: 10px;
  padding: 10px;
  border-radius: 5px;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.producto-imagen {
    width: 50px;
    height: auto;
    margin-right: 10px;
}

#lista-productos button {
    background-color: #ffd700;
    color: #1a1a1a;
    border: none;
    padding: 5px 10px;
    border-radius: 3px;
    cursor: pointer;
    transition: background-color .3s;
}

#lista-productos button:hover {
    background-color: #ffeb3b;
}

#carrito {
    position: fixed;
    top: 10px;
    right: 10px;
    background-color: #2a2a2a;
    padding: 20px;
    max-height: calc(80vh - 40px);
    overflow-y: auto;
    border: 2px solid #4a4a4a;
    border-radius: 10px;
    box-shadow: 0 0 20px rgba(255, 255, 255, 0.1);
}

#carrito h3 {
    color: #ffd700;
    text-align: center;
    margin-bottom: 15px;
}

#items-carrito {
    list-style-type: none;
    padding: 0;
}

#items-carrito li {
    background-color: #3a3a3a;
    margin-bottom: 10px;
    padding: 10px;
    border-radius: 5px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

#items-carrito button {
    background-color: #080202;
    color: #ffffff;
    border: none;
    padding: 5px 10px;
    border-radius: 3px;
    cursor: pointer;
    transition: background-color .3s;
}

#items-carrito button:hover {
    background-color: #ff6666;
}

#total-carrito {
    font-size: 1.2em;
    font-weight: bold;
    color: #ffd700;
}
/* From Uiverse.io by Creatlydev */ 
.Btn {
  width: 130px;
  height: 40px;
  display: flex;
  align-items: center;
  justify-content: center;
  background-color: rgb(15, 15, 15);
  border: none;
  color: white;
  font-weight: 600;
  gap: 8px;
  cursor: pointer;
  box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.103);
  position: relative;
  overflow: hidden;
  transition-duration: .3s;
}

.svgIcon {
  width: 16px;
}

.svgIcon path {
  fill: white;
}

.Btn::before {
  width: calc(100% + 40px);
  aspect-ratio: 1/1;
  position: absolute;
  content: "";
  background-color: white;
  border-radius: 50%;
  left: -20px;
  top: 50%;
  transform: translate(-150%, -50%);
  transition-duration: .5s;
  mix-blend-mode: difference;
}

.Btn:hover::before {
  transform: translate(0, -50%);
}

.Btn:active {
  transform: translateY(4px);
  transition-duration: .3s;
}
/* From Uiverse.io by cssbuttons-io */ 
button {
  align-items: center;
  background-image: linear-gradient(#ffd700);
  border: 0;
  border-radius: 8px;
  box-shadow: rgba(151, 65, 252, 0.2) 0 15px 30px -5px;
  box-sizing: border-box;
  color: #ffffff;
  display: flex;
  font-size: 18px;
  justify-content: center;
  line-height: 1em;
  max-width: 100%;
  min-width: 140px;
  padding: 3px;
  text-decoration: none;
  user-select: none;
  -webkit-user-select: none;
  touch-action: manipulation;
  white-space: nowrap;
  cursor: pointer;
  transition: all 0.3s;
}

button:active,
button:hover {
  outline: 0;
}

button span {
  background-color: #ffd700; 
  padding: 16px 24px;
  border-radius: 6px;
  width: 100%;
  height: 100%;
  transition: 300ms;
}

button:hover span {
  background: none;
}

button:active {
  transform: scale(0.9);
}
`;

// Agregar estilos al documento
const styleSheet = document.createElement("style");
styleSheet.innerText = styles;
document.head.appendChild(styleSheet);

// Crear elementos del menú y carrito
const popupMenu = document.createElement('div');
popupMenu.id = 'popup-menu';
popupMenu.innerHTML = `
<h2>Menú de Productos</h2>
<ul id="lista-productos"></ul>
<button onclick="cerrarMenu()"><span class="text">Cerrar</span></button>
`;

// Crear el carrito
const carrito = document.createElement('div');
carrito.id = 'carrito';
carrito.innerHTML = `
<h3>Carrito</h3>
<ul id="items-carrito"></ul>
<p>Total: $<span id="total-carrito">0</span></p>
<button class="Btn" id="btn-pagar">
  Pagar
  <svg viewBox="0 0 576 512" class="svgIcon">
    <path d="M512 80c8.8 0 16 7.2 16 16v32H48V96c0-8.8 7.2-16 16-16H512zm16 144V416c0 8.8-7.2 16-16 16H64c-8.8 0-16-7.2-16-16V224H528zM64 32C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H512c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H64zm56 304c-13.3 0-24 10.7-24 24s10.7 24 24 24h48c13.3 0 24-10.7 24-24s-10.7-24-24-24H120zm128 0c-13.3 0-24 10.7-24 24s10.7 24 24 24H360c13.3 0 24-10.7 24-24s-10.7-24-24-24H248z"></path>
   </svg>
</button>
`;

document.body.appendChild(popupMenu);
document.body.appendChild(carrito);

let productos = [];
let carritoItems = [];

function mostrarMenu(event) {
    event.preventDefault();
    document.getElementById('popup-menu').style.display = 'block';
    cargarProductos();
}

function cerrarMenu() {
    document.getElementById('popup-menu').style.display = 'none';
}

function cargarProductos() {
    fetch('obtener_productos.php')
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                console.error('Error:', data.error);
                return;
            }
            productos = data;

            const lista = document.getElementById('lista-productos');
            lista.innerHTML = '';
            productos.forEach(producto => {
                lista.innerHTML += `
                    <li>
                        <img src="${producto.imagen}" alt="${producto.nombre}" class="producto-imagen">
                        ${producto.nombre} - $${producto.precio}
                        <button onclick="agregarAlCarrito(${producto.id})">Agregar al carrito</button>
                    </li>`;
            });
        })
        .catch(error => console.error('Error:', error));
}

function agregarAlCarrito(id) {
    const producto = productos.find(p => p.id == id);
    if (producto) { // Verifica si el producto existe
        carritoItems.push(producto);
        actualizarCarrito();
    }
}

function actualizarCarrito() {
    const lista = document.getElementById('items-carrito');
    lista.innerHTML = '';
    let total = carritoItems.reduce((acc, item) => acc + parseFloat(item.precio), 0); // Sumar precios

    carritoItems.forEach((item, index) => {
        lista.innerHTML += `
            <li>
                ${item.nombre} - $${item.precio}
                <button onclick="eliminarDelCarrito(${index})">Eliminar</button>
            </li>`;
    });

    document.getElementById('total-carrito').textContent = total.toFixed(2);
}

function eliminarDelCarrito(index) {
    carritoItems.splice(index, 1); // Eliminar del carrito
    actualizarCarrito();
}

// Esperar a que el DOM esté completamente cargado
document.addEventListener('DOMContentLoaded', function() {
    // Buscar el enlace del menú
    const menuLink = Array.from(document.querySelectorAll('.btn-1')).find(el => el.textContent.trim().toLowerCase() === 'menu');

    if (menuLink) {
        menuLink.addEventListener('click', mostrarMenu);
    }
});
