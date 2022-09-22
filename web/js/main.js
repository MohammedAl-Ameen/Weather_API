//#region DOM Elemnts 
let weatherInfoButton = document.getElementById("info");
let city_name = document.getElementById("city_name");
let weather_container = document.getElementById("weather-container");
let weather_wrap = document.getElementById("weather-wrap");
//#endregion

clearCard()

//#region Constants
const H1_TAG = "h1";
const H3_TAG = "h3";
const H6_TAG = "h6";
const P_TAG = "p";
const TR_TAG = "tr";
const TD_TAG = "td";
const TBODY_TAG = "tbody";
const TABLE_TAG = "table";
//#endregion


//#region  Event listeners

/// <summary>
///  This function handle creating custom elements
/// </summary>
weatherInfoButton.addEventListener("click", async () => {
    try {
        const data = await getData();
        clearCard();
        createCard(data);
    }
    catch (ex) {
        console.log(ex)
    }
})
//#endregion


//#region UI creation methods

/// <summary>
/// Fetch data from API based on user input
/// Returns data from API
/// </summary>
async function getData() {
    try {
        let url = `https://api.openweathermap.org/data/2.5/weather?q=${city_name.value}&appid=8be405bba210e640bd433e313ddfa269&units=metric`;
        const response = await fetch(url);
        const data = await response.json();
        return data
    }
    catch (ex) {
        console.log(ex)
        return {}
    }
}


/// <summary>
/// Clear UI card
/// </summary>
function clearCard() {
    try {
        weather_wrap.innerHTML = ""
    }
    catch (ex) {
        console.log(ex)
    }
}

/// <summary>
/// Create a card in the UI
/// </summary>
function createCard(data) {
    try {
        createElement(H6_TAG, secondsToDateFormat(data.dt), weather_wrap)
        createElement(H3_TAG, data.name + " , " + data.sys.country, weather_wrap)
        createElement(H1_TAG, data.main.temp + " °C", weather_wrap);
        createElement(P_TAG, "Feels like: " + data.main.feels_like + " °C , " + data.weather[0].description, weather_wrap);

        createTable(data);
    }
    catch (ex) {
        console.log(ex)
    }

}

/// <summary>
///  Create a table inside a card
/// </summary>
function createTable(data) {
    try {
        let table = createElement("table", null, weather_wrap);
        let tbody = createElement("tbody", null, table);

        createColumn(data.wind.speed + "m/s W", data.main.pressure + "hPa", tbody);

        createColumn("humidity: " + data.humidity + "%", data.visibility + "m", tbody);

        createColumn("Min Temp: " + data.main.temp_min + " °C", "Max Temp: " + data.main.temp_max + " °C", tbody);
    }
    catch (ex) {
        console.log(ex)
    }
}

/// <summary>
/// Creates a <td> element within a <tr> elemnt
/// </summary>
function createColumn(data_col1, data_col2, tbody) {
    try {
        tr = createElement("tr", null, tbody);
        createElement("td", data_col1, tr);
        createElement("td", data_col2, tr);
    }
    catch (ex) {
        console.log(ex)
    }
}

//#endregion


//#region Generic Methods

/// <summary>
///  This function handle creating custom elements with the option of appending it to an already existing one
/// </summary>
function createElement(tag_type, data = null, parent_tag = null) {
    try {
        let element = document.createElement(tag_type);
        let newContent = data ? document.createTextNode(data) : "";
        newContent ? element.appendChild(newContent) : "";
        parent_tag ? parent_tag.append(element) : " ";
        return element
    }
    catch (ex) {
        console.log(ex)
        return {}
    }
}

/// <summary>
///  convert seconds fetched from API to a readable Date formate for the user
/// </summary>
function secondsToDateFormat(sec) {
    try {
        let temp = sec + "000";
        let newdate = new Date(parseInt(temp));
        let str = newdate.toString().substr(0, 25);
        return str;
    }
    catch (ex) {
        console.log(ex)
        return ""
    }
}
//#endregion
