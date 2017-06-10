using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using static SynchronisationShared.SharedEnums;

namespace SynchronisationDataManager.Clients
{
    public class DatabaseClientFactory
    {
        private static DB2Client internalClientDB2;
        private static MySQLClient internalClientMYSQL;

        public static DatabaseClient GetClient(DatabaseType type)
        {
            switch (type)
            {
                case DatabaseType.DB2:
                    if(internalClientDB2 == null)
                    {
                        internalClientDB2 = new DB2Client();
                    }
                    return internalClientDB2;
                case DatabaseType.MYSQL:
                    if (internalClientMYSQL == null)
                    {
                        internalClientMYSQL = new MySQLClient();
                    }
                    return internalClientMYSQL;
            }

            //I challenge you to get here...
            return null;
        }
    }
}
