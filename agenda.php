
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/css/materialize.min.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500" rel="stylesheet"> 
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="stylesheet" href="styles/agenda.css">
  </head>

  <body>
  
  <div class="container">
   <a href="index.php" class="close">
</div>
<
<!--<header>
  <div class="logo-with-bg">
    <a href=""><span>Poulain Automobiles</span></a></div>
</header>-->
   <div class="main-wrapper">
      <div class="sidebar-wrapper z-depth-2 side-nav fixed" id="sidebar">
         <div class="sidebar-title">
            <h4>Evenements</h4>
               <h5 id="eventDayName">Date</h5>
                  </div>
                     <div class="sidebar-events" id="sidebarEvents">
                        <div class="empty-message">Désolé, pas d'Evenements à cette date</div>
                           </div>
</div>
<div class="content-wrapper grey lighten-3">
  <div class="container">

    <div class="calendar-wrapper z-depth-2">

      <div class="header-background">
        <div class="calendar-header">

          <a class="prev-button" id="prev">
            <i class="material-icons"></i>
          </a>
          <a class="next-button" id="next">
            <i class="material-icons"></i>
          </a>

          <div class="row header-title">

            <div class="header-text">
              <h3 id="month-name"></h3>
              <h5 id="todayDayName"></h5>
            </div>

          </div>
        </div>
      </div>

      <div class="calendar-content">
        <div id="calendar-table" class="calendar-cells">

          <div id="table-header">
            <div class="row">
              <div class="col">Lun</div>
              <div class="col">Mar</div>
              <div class="col">Mer</div>
              <div class="col">Jeu</div>
              <div class="col">Ven</div>
              <div class="col">Sam</div>
              <div class="col">Dim</div>
            </div>
          </div>

          <div id="table-body" class="">
<!--neant-->
          </div>

        </div>
      </div>

      <div class="calendar-footer">
        <div class="emptyForm" id="emptyForm">
          <h4 id="emptyFormTitle">Pas d'Evenements</h4>
          <a class="addEvent" id="changeFormButton">Add new</a>
        </div>
        <div class="addForm" id="addForm">
          <h4>Ajouter un nouvel Evenement</h4>

          <div class="row">
            <div class="input-field col s6">
              <input id="eventTitleInput" required type="text" class="validate">
              <label for="eventTitleInput" aria-required="true" >Titre</label>
            </div>
            <div class="input-field col s6">
              <input id="eventDescInput" required type="text" class="validate">
              <label for="eventDescInput" aria-required="true" >Description</label>
            </div>
          </div>
          <div class="addEventButtons">
            <a class="waves-effect waves-light btn blue lighten-2" id="addEventButton">Ajouter</a>
            <a class="waves-effect waves-light btn grey lighten-2" id="cancelAdd">Effacer</a>
          </div>

        </div>
      </div>

    </div>

  </div>
</div>

</div>
    <div class="center-div" style="text-align: right;" >
              <a href="index.php" class="back">
                  <div>
                  </div>
                    <h5>Poulain Automobiles</h5>
                      <span>Retour Acceuil</span>
                          </a>
                              <span></span>       
      </div>       
         </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh"
            crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ"
            crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/js/materialize.min.js"></script>
    <script>
      // les codes couleurs sont reliés aux variables
      $(".button-collapse").sideNav();
      var calendar = document.getElementById("calendar-table");
var gridTable = document.getElementById("table-body");
var currentDate = new Date();
var selectedDate = currentDate;
var selectedDayBlock = null;
var globalEventObj = {};

var sidebar = document.getElementById("sidebar");

function createCalendar(date, side) {
   var currentDate = date;
   var startDate = new Date(currentDate.getFullYear(), currentDate.getMonth(), 1);

   var monthTitle = document.getElementById("month-name");
   var monthName = currentDate.toLocaleString("en-US", {
      month: "long"
   });
   var yearNum = currentDate.toLocaleString("en-US", {
      year: "numeric"
   });
   monthTitle.innerHTML = `${monthName} ${yearNum}`;

   if (side == "left") {
      gridTable.className = "animated fadeOutRight";
   } else {
      gridTable.className = "animated fadeOutLeft";
   }

   setTimeout(() => {
      gridTable.innerHTML = "";

      var newTr = document.createElement("div");
      newTr.className = "row";
      var currentTr = gridTable.appendChild(newTr);

      for (let i = 1; i < startDate.getDay(); i++) {
         let emptyDivCol = document.createElement("div");
         emptyDivCol.className = "col empty-day";
         currentTr.appendChild(emptyDivCol);
      }

      var lastDay = new Date(currentDate.getFullYear(), currentDate.getMonth() + 1, 0);
      lastDay = lastDay.getDate();

      for (let i = 1; i <= lastDay; i++) {
         if (currentTr.children.length >= 7) {
            currentTr = gridTable.appendChild(addNewRow());
         }
         let currentDay = document.createElement("div");
         currentDay.className = "col";
         if (selectedDayBlock == null && i == currentDate.getDate() || selectedDate.toDateString() == new Date(currentDate.getFullYear(), currentDate.getMonth(), i).toDateString()) {
            selectedDate = new Date(currentDate.getFullYear(), currentDate.getMonth(), i);

            document.getElementById("eventDayName").innerHTML = selectedDate.toLocaleString("en-US", {
               month: "long",
               day: "numeric",
               year: "numeric"
            });

            selectedDayBlock = currentDay;
            setTimeout(() => {
               currentDay.classList.add("blue");
               currentDay.classList.add("lighten-3");
            }, 900);
         }
         currentDay.innerHTML = i;

         //show marks
         if (globalEventObj[new Date(currentDate.getFullYear(), currentDate.getMonth(), i).toDateString()]) {
            let eventMark = document.createElement("div");
            eventMark.className = "day-mark";
            currentDay.appendChild(eventMark);
         }

         currentTr.appendChild(currentDay);
      }

      for (let i = currentTr.getElementsByTagName("div").length; i < 7; i++) {
         let emptyDivCol = document.createElement("div");
         emptyDivCol.className = "col empty-day";
         currentTr.appendChild(emptyDivCol);
      }

      if (side == "left") {
         gridTable.className = "animated fadeInLeft";
      } else {
         gridTable.className = "animated fadeInRight";
      }

      function addNewRow() {
         let node = document.createElement("div");
         node.className = "row";
         return node;
      }

   }, !side ? 0 : 270);
}

createCalendar(currentDate);

var todayDayName = document.getElementById("todayDayName");
todayDayName.innerHTML = "Today is " + currentDate.toLocaleString("en-US", {
   weekday: "long",
   day: "numeric",
   month: "short"
});

var prevButton = document.getElementById("prev");
var nextButton = document.getElementById("next");

prevButton.onclick = function changeMonthPrev() {
   currentDate = new Date(currentDate.getFullYear(), currentDate.getMonth() - 1);
   createCalendar(currentDate, "left");
}
nextButton.onclick = function changeMonthNext() {
   currentDate = new Date(currentDate.getFullYear(), currentDate.getMonth() + 1);
   createCalendar(currentDate, "right");
}

function addEvent(title, desc) {
   if (!globalEventObj[selectedDate.toDateString()]) {
      globalEventObj[selectedDate.toDateString()] = {};
   }
   globalEventObj[selectedDate.toDateString()][title] = desc;
}

function showEvents() {
   let sidebarEvents = document.getElementById("sidebarEvents");
   let objWithDate = globalEventObj[selectedDate.toDateString()];

   sidebarEvents.innerHTML = "";

   if (objWithDate) {
      let eventsCount = 0;
      for (key in globalEventObj[selectedDate.toDateString()]) {
         let eventContainer = document.createElement("div");
         eventContainer.className = "eventCard";

         let eventHeader = document.createElement("div");
         eventHeader.className = "eventCard-header";

         let eventDescription = document.createElement("div");
         eventDescription.className = "eventCard-description";

         eventHeader.appendChild(document.createTextNode(key));
         eventContainer.appendChild(eventHeader);

         eventDescription.appendChild(document.createTextNode(objWithDate[key]));
         eventContainer.appendChild(eventDescription);

         let markWrapper = document.createElement("div");
         markWrapper.className = "eventCard-mark-wrapper";
         let mark = document.createElement("div");
         mark.classList = "eventCard-mark";
         markWrapper.appendChild(mark);
         eventContainer.appendChild(markWrapper);

         sidebarEvents.appendChild(eventContainer);

         eventsCount++;
      }
      let emptyFormMessage = document.getElementById("emptyFormTitle");
      emptyFormMessage.innerHTML = `${eventsCount} events now`;
   } else {
      let emptyMessage = document.createElement("div");
      emptyMessage.className = "empty-message";
      emptyMessage.innerHTML = "Sorry, no events to selected date";
      sidebarEvents.appendChild(emptyMessage);
      let emptyFormMessage = document.getElementById("emptyFormTitle");
      emptyFormMessage.innerHTML = "No events now";
   }
}

gridTable.onclick = function (e) {

   if (!e.target.classList.contains("col") || e.target.classList.contains("empty-day")) {
      return;
   }

   if (selectedDayBlock) {
      if (selectedDayBlock.classList.contains("blue") && selectedDayBlock.classList.contains("lighten-3")) {
         selectedDayBlock.classList.remove("blue");
         selectedDayBlock.classList.remove("lighten-3");
      }
   }
   selectedDayBlock = e.target;
   selectedDayBlock.classList.add("blue");
   selectedDayBlock.classList.add("lighten-3");

   selectedDate = new Date(currentDate.getFullYear(), currentDate.getMonth(), parseInt(e.target.innerHTML));

   showEvents();

   document.getElementById("eventDayName").innerHTML = selectedDate.toLocaleString("en-US", {
      month: "long",
      day: "numeric",
      year: "numeric"
   });

}

var changeFormButton = document.getElementById("changeFormButton");
var addForm = document.getElementById("addForm");
changeFormButton.onclick = function (e) {
   addForm.style.top = 0;
}

var cancelAdd = document.getElementById("cancelAdd");
cancelAdd.onclick = function (e) {
   addForm.style.top = "100%";
   let inputs = addForm.getElementsByTagName("input");
   for (let i = 0; i < inputs.length; i++) {
      inputs[i].value = "";
   }
   let labels = addForm.getElementsByTagName("label");
   for (let i = 0; i < labels.length; i++) {
      labels[i].className = "";
   }
}

var addEventButton = document.getElementById("addEventButton");
addEventButton.onclick = function (e) {
   let title = document.getElementById("eventTitleInput").value.trim();
   let desc = document.getElementById("eventDescInput").value.trim();

   if (!title || !desc) {
      document.getElementById("eventTitleInput").value = "";
      document.getElementById("eventDescInput").value = "";
      let labels = addForm.getElementsByTagName("label");
      for (let i = 0; i < labels.length; i++) {
         labels[i].className = "";
      }
      return;
   }

   addEvent(title, desc);
   showEvents();

   if (!selectedDayBlock.querySelector(".day-mark")) {
      selectedDayBlock.appendChild(document.createElement("div")).className = "day-mark";
   }

   let inputs = addForm.getElementsByTagName("input");
   for (let i = 0; i < inputs.length; i++) {
      inputs[i].value = "";
   }
   let labels = addForm.getElementsByTagName("label");
   for (let i = 0; i < labels.length; i++) {
      labels[i].className = "";
   }

}
    </script>
    <footer>
                    <p>Copyright &copy; 2023 Olivier Poulain Designer Web Developpeur Droits réservés  o.poulain@outlook.com</p>
                        </footer>
  </body>
</html>