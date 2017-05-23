using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace SynchronisationLib
{
    public class SyncService
    {
        SynchronisationService.SynchronisationWCFClient client = new SynchronisationService.SynchronisationWCFClient();

        public SyncService()
        {

        }

        public int Ping()
        {
            return client.Ping();
        }

        //TODO: implement other methods
    }
}
