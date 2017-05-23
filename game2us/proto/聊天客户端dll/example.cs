using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using fxclient;

namespace WindowsFormsApplication1
{
    class Class2
    {
        ClientSocket clientS = new ClientSocket("192.168.1.179", 20001);

        public void CallBackToMain(ushort wMsgId, ushort wError,  object oObject)
        {
            if (wMsgId == Convert.ToUInt16(SOCKET_MSG.SOCKET_MSG_LOGIN))
            {
                SOCKET_SC_LOGIN login = (SOCKET_SC_LOGIN)oObject;
            }
            else if (wMsgId == Convert.ToUInt16(SOCKET_MSG.SOCKET_MSG_CHAT))
            {
                SOCKET_SC_CHAT chat = (SOCKET_SC_CHAT)oObject;
            }

        }

        public void test()
        {
            SOCKET_CS_LOGIN login = new SOCKET_CS_LOGIN();
            login.uUserId = 1;
            CallBackDelegate callBack = CallBackToMain;
            clientS.TryConnect();
            clientS.Send(1, login, callBack);
        }
    }
}
