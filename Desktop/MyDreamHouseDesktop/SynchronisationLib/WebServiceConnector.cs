using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using SynchronisationLib.SynchronisationService;

namespace SynchronisationLib
{
    class WebServiceConnector
    {
        SynchronisationWCFClient client = new SynchronisationService.SynchronisationWCFClient();

        public WebServiceConnector()
        {

        }

        public void SendChanges(HauspaketDTO hauspaket)
        {
            client.SaveHauspaket(hauspaket);
        }

        public SyncDataSet FullSync()
        {
            return client.Synchronize("", "");
        }

        public SyncDataSet PartialSync()
        {
            return client.Synchronize("", "");
        }

        public int Ping()
        {
            return client.Ping();
        }

    }
}
