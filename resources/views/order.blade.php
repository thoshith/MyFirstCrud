<!DOCTYPE html>
<html>
<head>
<script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js">
        </script>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<style>
.h1{
   text-align: center;
   font-family: arial;
  }
.card {
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
  max-width: 300px;
  margin: auto;
  text-align: center;
  font-family: arial;
}

.price {
  color: grey;
  font-size: 22px;
}

.card button {
  border: none;
  outline: 0;
  padding: 12px;
  color: white;
  background-color: #000;
  text-align: center;
  cursor: pointer;
  width: 100%;
  font-size: 18px;
}

.card button:hover {
  opacity: 0.7;
}
</style>
<script type="text/javascript">

      window.onload=getList;
      var words =[];

      function getList(){
        var arrlen=window.location.href.split(',').length;
        const params = window.location.href;
        var rest = params.substring(0, params.lastIndexOf("/") + 1);
        var last = params.substring(params.lastIndexOf("/") + 1, params.length);
        words= last.split(',');
        words = words.map(Number);
        console.log(words);  

        getFoodDetails();
      }

      function getFoodDetails() {
          var tot_amt=[]; 
          var fid=[];
          var sum=0;
          var arr = [];
          var c1=c2=c3=c4=0;  var pricearr =[];
          for(let i=0;i<words.length;i++){
              switch(words[i]){
                 case 1:c1++;
                         break;
                 case 2:c2++;
                          break;
                 case 3:c3++;
                          break;
                 case 4:c4++;
                          break;
                  }
             
            }
             if(c1>=1){
              fid.push(1);
              arr[1]=c1; 
            }

             if(c2>=1){
              fid.push(2);
              arr[2]=c2;
            }
             if(c3>=1){
              fid.push(3);
               arr[3]=c3;
             }
             if(c4>=1){
              fid.push(4);
              arr[4]=c4;
             }
             console.log("in associative array");
             for(var i in arr){
                console.log(i + "=" + arr[i] + '<br>');
              }
             console.log(fid)
             //for(let i=0;i<fid.length;i++){
               for(var i in arr){
                $.ajax({
                type:'Get',
                url:'/api/food/'+i,
                success:function(response) {
                console.dir(response);
                var len = response.data.length;
                var out_name,out_cost,out_qty,j;
                
                for(j=0;j<len;j++){
                  out_name ='<table >';
                  out_name +='<tr><td>'+response.data[j].fname+'</td></tr>';
                  out_name +='<table>';
                  $('#item_name').append(out_name);
                }
           
                for(j=0;j<len;j++){
                  var price=response.data[j].price;

                  out_cost ='<table>';
                  out_cost +='<tr><td>'+price+'</td></tr>';
                  out_cost +='<table>';
                  tot_amt.push(price*qty);
                    console.log("amt --->>> "+tot_amt);
                  $('#item_cost').append(out_cost);
                }
         
              tot_amt = tot_amt.map(Number);
              console.log("amt ---> "+tot_amt);
              sum = tot_amt.reduce(function(a, b){
              return a + b;
              }, 0);
                document.getElementById("bill").innerHTML = "Total Amount ="+sum ;
              }

         });
      }
                        
               for(var i in arr){
                var qty=arr[i]
                out_qty ='<table>';
                out_qty +='<tr><td>'+qty+'</td></tr>';
                out_qty +='<table>';
                $('#item_qty').append(out_qty);
                }
};
</script>
<script type="text/javascript">
  function orderPlaced(){
    var cardnum=$("#cardnum").val();
    if(cardnum == 0){
      alert("plz fill card number");
      $("#cardnum").focus();
    }
    else if(cardnum.length<10){
      alert("card number must have 10 digit");
      $("#cardnum").focus();
    }
    else
    {    var neworder = new Object();  
         neworder.userid = 22; 
         neworder.amount= 230.00;
        $.ajax({
          type: "POST",
          url: '/api/Orders',
          dataType: 'json',
          data: neworder,
          success: function(response){
              console.log(response);
              $("#orderresult").append("Your order is placed " + response.data);   
          },
          
    });

      
    }
  }
function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}
</script>
</head>
<body>
<div class="container-fluid">
  <div>
        <h1>HOTEL VISHVESH </h1>
  </div>
    <div class="row" id="items_name">
    </div>
        <hr>
        <div class="row" >
          <div class="col-sm-4" id="item_name">item_name </div>
          <div class="col-sm-4" id="item_cost"> item_cost </div>
          <div class="col-sm-4" id="item_qty"> item_qty </div>

        </div>
        
          <div class="row" >
            <div class="col-sm-6"> </div>
            <div class="col-sm-6"> <p id="bill">  Total Amount  </p>  </div>
          </div>
          
          <div><div class="row" >
            <div class="col-sm-2"> Give Card Number</div>
            <div class="col-sm-2"> <input type="text" id="cardnum" placeholder="Enter card number" maxlength="10" onkeypress="return isNumber(event)"> </div>
          </div>
          <div><div class="row" >
            <div class="col-sm-10"> </div>
            <div class="col-sm-2"> <input type="submit" value="PlaceOrder" id="Placeorder" onclick="orderPlaced()"></div>
          </div>

          <div><div class="row" >
            <div class="col-sm-10" id="orderresult"> </div>
            <div class="col-sm-2" ></div>
          </div>
</div> 

          
</body>
</html>

