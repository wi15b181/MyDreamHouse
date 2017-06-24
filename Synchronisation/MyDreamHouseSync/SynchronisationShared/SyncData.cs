using System;
using System.Collections.Generic;
using System.Linq;
using System.Runtime.Serialization;
using System.ServiceModel;
using System.Text;
using System.Threading.Tasks;

namespace SynchronisationShared
{
    public abstract class SyncData
    {
        public string SyncOperation {
            [OperationContract]
            get;
            set; }
    }
}
