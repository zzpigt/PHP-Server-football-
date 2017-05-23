using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using fxclient;
using System.Windows.Forms;

namespace WindowsFormsApplication1
{
    class Class2
    {
        static  ClientSocket clientS = new ClientSocket("222.186.12.171", 20001);
        static bool bConnect = false;
        static Form1 mainForm;

        public static void SetForm( Form1 form1)
        {
            mainForm = form1;
        }

        public static void CallBackToMain(ushort wMsgId, ushort wError,  object oObject)
        {
            Form1.delegateNewMsg d = mainForm.dgtNewMsgMethod;
           
            if (wMsgId == Convert.ToUInt16(SOCKET_MSG.SOCKET_MSG_LOGIN))
            {
                SOCKET_SC_LOGIN login = (SOCKET_SC_LOGIN)oObject;

                mainForm.textBox1.Invoke(d, "登录成功");//访问主线程资源
            }
            else if (wMsgId == Convert.ToUInt16(SOCKET_MSG.SOCKET_MSG_CHAT))
            {
                SOCKET_SC_CHAT chat = (SOCKET_SC_CHAT)oObject;
                mainForm.textBox1.Invoke(d, chat.strContent);//访问主线程资源
            }

        }

        public void test()
        {
            SOCKET_CS_LOGIN login = new SOCKET_CS_LOGIN();
            login.uUserId = 1;
            CallBackDelegate callBack = CallBackToMain;
            if(clientS.TryConnect())
            {
                clientS.Send(1, login, callBack);
            }
        }

        public static bool Connect()
        {
            bConnect = clientS.TryConnect();
            return bConnect;
        }

        public static void Login(uint uUserId)
        {
            if (!bConnect)
            {
                return;
            }
            SOCKET_CS_LOGIN login = new SOCKET_CS_LOGIN();
            login.uUserId = uUserId;
            CallBackDelegate callBack = CallBackToMain;
            clientS.Send(1, login, callBack);
        }

        public static void Chat(string content)
        {
            if (!bConnect)
            {
                return;
            }
            SOCKET_CS_CHAT chat = new SOCKET_CS_CHAT();
            chat.strContent = content;
            CallBackDelegate callBack = CallBackToMain;
            clientS.Send(2, chat, callBack);
        }
    }
}
