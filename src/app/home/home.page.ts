import { Component } from '@angular/core';
import { FormGroup,FormBuilder, Validators } from '@angular/forms';
import { HttpClientModule,HttpClient } from '@angular/common/http';
import { ToastController } from '@ionic/angular';

@Component({
  selector: 'app-home',
  templateUrl: 'home.page.html',
  styleUrls: ['home.page.scss'],
})
export class HomePage {

  my_form: FormGroup;
  userName_flag: Object;
  my_form_valid=false;
  password_not_valid=true;

  constructor(
    private formbuilder: FormBuilder,
    private http: HttpClient,
    public toastController: ToastController
  ) {
    this.my_form= this.formbuilder.group({
      first_name:['',[Validators.required]],
      last_name:['',[Validators.required]],
      user_name:['',[Validators.required]],
      password:['',[Validators.required]]
    });

    this.my_form.valueChanges.subscribe(form_data=>{
      console.log(form_data);
      if(form_data['first_name']!='' && form_data['last_name']!='' && form_data['user_name']!='' && form_data['password'].match(/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{8,}$/) && this.userName_flag==true ){
        this.my_form_valid=true;
        console.log("form valid");
      }else{
        this.my_form_valid=false;
        console.log("form invalid");
      }

      if(!form_data['password'].match(/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{8,}$/) && form_data['password']!=''){
        this.password_not_valid=form_data['password'].match(/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{8,}$/);
      }else{
        this.password_not_valid=true;
      }
    })
  }

  submit_function(){
    //this.form
    this.presentToast('SuccessFully saved!')
    console.log(this.my_form.value);
  }

  check_userName(){
    var url="https://www.reddit.com/api/username_available.json?user=ironman43223";
    this.http.get(url).subscribe(res=>{
      if (res==true){
        this.presentToast('UserName Is Valid')
      }else{
        this.presentToast('UserName Is Not available!')
      }
      this.userName_flag=res;
    })
  }

  // check_password(){

  // }

  async presentToast(text) {
    const toast = await this.toastController.create({
      message: text,
      duration: 2000
    });
    toast.present();
  }

  

}
