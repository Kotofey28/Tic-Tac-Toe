let cells = ['...', '...', '...', '...', '...', '...', '...', '...', '...'];
let currentPlayer = 'X';
let result = document.querySelector('.result'); //в html чей ход
let btns = document.querySelectorAll('.btn'); // в html кнопки
let story = document.querySelector('#story');
let conditions = [ //варианты победы
    [0, 1, 2],
    [3, 4, 5],
    [6, 7, 8],
    [0, 3, 6],
    [1, 4, 7],
    [2, 5, 8],
    [0, 4, 8],
    [2, 4, 6]
];
// Открываем websocket соединение
const ws = new WebSocket('ws://localhost:2346');

const ticTacToe = (element, index) => {
    story.disabled = true;
    element.value = currentPlayer; // вносит в клетку X или 0
    element.disabled = true; // выключаем кнопку
    cells[index] = currentPlayer; // заносим ход в массив
    currentPlayer = currentPlayer == 'X' ? 'O' : 'X'; // меняем ход игрока
    result.innerHTML = `Player ${currentPlayer} Turn`; // выводим чья очередь ходить

    //проверка на ничью
    let emp = 0;
    for(let i=0; i<9; i++){
        if(cells[i] == '...'){
            emp = emp + 1;
        }
    }
    if(emp == 0){
        result.innerHTML = `Draw!`;
    }

    for (let i = 0; i < conditions.length; i++) { //просматриваем все варианты вигрыша
        let condition = conditions[i];
        let a = cells[condition[0]];
        let b = cells[condition[1]];
        let c = cells[condition[2]];


        if (a == '...' || b == '...' || c == '...') {
            continue;
        }

        //если все три ячейки одного значения, то определяем победителя
        if ((a == b) && (b == c)) {
            result.innerHTML = `Player ${a} Won!`; //выводим победителя
            btns.forEach((btn) => btn.disabled = true); // блокируем все кнопки
        }
    }
    let res = {
        c: cells,
        i: index,
        xo: element.value,
       inf: result.innerHTML
    }

    ws.send(JSON.stringify(res));
};

//функция обнуления игры
function reset() {
    story.disabled = false;
    cells = ['...', '...', '...', '...', '...', '...', '...', '...', '...']; //все ячейки делаем пустыми
    btns.forEach((btn) => {
        btn.value = '   '; //все кнопки пустые
    });
    currentPlayer = 'X'; //определяем кто первый ходит
    result.innerHTML = `Player X Turn`; //выводим чей ход
    btns.forEach((btn) => btn.disabled = false); //делаем все кнопки включенными
};

document.querySelector('#reset').addEventListener('click', reset); //по нажатию кнопки reset, запустить функцию reset

//если нажата какая-то кнопка из всех, то применить к ней функцию tic-tac-toe
btns.forEach((btn, i) => {
    btn.addEventListener('click', () => ticTacToe(btn, i));
});

ws.onmessage = response => {
    let res = JSON.parse(response.data);
    cells[res.i] = res.xo;
    btns[res.i].value = res.xo;
    btns[res.i].disabled = true;
    currentPlayer = cells[res.i] == 'X' ? 'O' : 'X'; // меняем ход игрока
    result.innerHTML = res.inf;

    if(res.inf.endsWith('Won!')|| res.inf.endsWith('Draw!')){
        btns.forEach((btn) => btn.disabled = true); // блокируем все кнопки
        story.disabled = false;
    }
};

