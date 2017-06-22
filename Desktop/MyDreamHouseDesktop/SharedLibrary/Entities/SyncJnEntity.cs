using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace SharedLibrary.Entities
{
    public class SyncJnEntity
    {
        public int JnId { get; set; }

        public string JnTable { get; set; }

        public DateTime JnTimestamp { get; set; }

        public int JnPk { get; set; }

        public string JnOperation { get; set; }

        public bool Synced { get; set; }

        public string JnChangesetJson { get; set; }
    }
}
