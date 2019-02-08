using System;
using System.Collections;
using System.Collections.Generic;
using System.Text;
namespace Marketplace_laravel
{
    #region Userssocial_credentials
    public class Userssocial_credentials
    {
        #region Member Variables
        protected int _id;
        protected string _social_webname;
        protected string _accesstoken;
        protected string _accesstokensecret;
        protected string _consumerkeyapikey;
        protected string _consumersecretapikey;
        protected string _instagram_access_token;
        protected string _hashtags;
        protected string _app_id;
        protected string _appsecret;
        protected string _username;
        protected int _user_id;
        protected unknown _created_at;
        protected unknown _updated_at;
        protected string _remember_token;
        #endregion
        #region Constructors
        public Userssocial_credentials() { }
        public Userssocial_credentials(string social_webname, string accesstoken, string accesstokensecret, string consumerkeyapikey, string consumersecretapikey, string instagram_access_token, string hashtags, string app_id, string appsecret, string username, int user_id, unknown created_at, unknown updated_at, string remember_token)
        {
            this._social_webname=social_webname;
            this._accesstoken=accesstoken;
            this._accesstokensecret=accesstokensecret;
            this._consumerkeyapikey=consumerkeyapikey;
            this._consumersecretapikey=consumersecretapikey;
            this._instagram_access_token=instagram_access_token;
            this._hashtags=hashtags;
            this._app_id=app_id;
            this._appsecret=appsecret;
            this._username=username;
            this._user_id=user_id;
            this._created_at=created_at;
            this._updated_at=updated_at;
            this._remember_token=remember_token;
        }
        #endregion
        #region Public Properties
        public virtual int Id
        {
            get {return _id;}
            set {_id=value;}
        }
        public virtual string Social_webname
        {
            get {return _social_webname;}
            set {_social_webname=value;}
        }
        public virtual string Accesstoken
        {
            get {return _accesstoken;}
            set {_accesstoken=value;}
        }
        public virtual string Accesstokensecret
        {
            get {return _accesstokensecret;}
            set {_accesstokensecret=value;}
        }
        public virtual string Consumerkeyapikey
        {
            get {return _consumerkeyapikey;}
            set {_consumerkeyapikey=value;}
        }
        public virtual string Consumersecretapikey
        {
            get {return _consumersecretapikey;}
            set {_consumersecretapikey=value;}
        }
        public virtual string Instagram_access_token
        {
            get {return _instagram_access_token;}
            set {_instagram_access_token=value;}
        }
        public virtual string Hashtags
        {
            get {return _hashtags;}
            set {_hashtags=value;}
        }
        public virtual string App_id
        {
            get {return _app_id;}
            set {_app_id=value;}
        }
        public virtual string Appsecret
        {
            get {return _appsecret;}
            set {_appsecret=value;}
        }
        public virtual string Username
        {
            get {return _username;}
            set {_username=value;}
        }
        public virtual int User_id
        {
            get {return _user_id;}
            set {_user_id=value;}
        }
        public virtual unknown Created_at
        {
            get {return _created_at;}
            set {_created_at=value;}
        }
        public virtual unknown Updated_at
        {
            get {return _updated_at;}
            set {_updated_at=value;}
        }
        public virtual string Remember_token
        {
            get {return _remember_token;}
            set {_remember_token=value;}
        }
        #endregion
    }
    #endregion
}