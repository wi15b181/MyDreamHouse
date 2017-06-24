using System;
using System.Collections.Generic;
using System.Linq;
using System.Runtime.Serialization;
using System.ServiceModel;
using System.Text;
using System.Threading.Tasks;

namespace SynchronisationShared
{
    public class SyncJn
    {
        public Nullable<int> JnId { get; set; }
        public string JnTable { get; set; }
        public string JnTimestamp { get; set; }
        public Nullable<int> JnPk { get; set; }
        public string JnOperation { get; set; }
        public Nullable<int> JnSynced { get; set; }
        public string JnChangesetJson { get; set; }
        public string JnApplication { get; set; }

        public SyncJn()
        {

        }
    }
}
