using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace SynchronisationDataManager.Clients
{
    public class DatabaseClientFactory
    {
        private static DB2Client internalClientDB2;
        private static MySQLClient internalClientMYSQL;

        public enum ClientType
        {
            DB2,
            MYSQL
        }

        public static DatabaseClient GetClient(ClientType type)
        {
            switch (type)
            {
                case ClientType.DB2:
                    if(internalClientDB2 == null)
                    {
                        internalClientDB2 = new DB2Client();
                    }
                    return internalClientDB2;
                case ClientType.MYSQL:
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
