using System;
using System.Collections.Generic;
using System.Linq;
using System.Runtime.Serialization;
using System.Text;
using System.Threading.Tasks;

namespace SynchronisationShared
{
    public class SharedEnums
    {
        public enum DatabaseType
        {
            DB2,
            MYSQL,
            LOCAL
        }
        
        public enum SyncType
        {
            [EnumMemberAttribute]
            INCREMENTAL,
            [EnumMemberAttribute]
            FULL
        }
    }
}
