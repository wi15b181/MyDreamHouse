using System;
using System.Collections.Generic;
using System.Data;
using System.Data.Common;
// Add the Common Assembly to add support for DataDirect Bulk Load
using DDTek.Data.Common;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using MySql.Data.MySqlClient;
using SynchronisationDataManager.Clients;
using static SynchronisationDataManager.Clients.DatabaseClientFactory;
using SynchronisationDataManager.Tables;
using SynchronisationShared;
using static SynchronisationShared.SharedEnums;

namespace SynchronisationDataManager
{
    public class DataManager
    {
        DatabaseClient ClientMySQL;
        DatabaseClient ClientDB2;

        public void FullSyncMySQLToDB2()
        {
            ClientDB2 = DatabaseClientFactory.GetClient(DatabaseType.DB2);
            ClientMySQL = DatabaseClientFactory.GetClient(DatabaseType.MYSQL);




            ClientDB2.ExecuteQuery("delete from berater", null);
            ClientDB2.ExecuteQuery("delete from hersteller", null);

            ClientDB2.ExecuteQuery("delete from ebook_statistic", null);
            ClientDB2.ExecuteQuery("delete from ebook", null);

            ClientDB2.ExecuteQuery("delete from attachements", null);
            ClientDB2.ExecuteQuery("delete from hauspaket_attribut_zuord", null);
            ClientDB2.ExecuteQuery("delete from hauspaket", null);
            ClientDB2.ExecuteQuery("delete from hauspaket_attribut_wert", null);
            ClientDB2.ExecuteQuery("delete from hauspaket_attribut", null);

            ClientDB2.ExecuteQuery("delete from benutzer", null);
            ClientDB2.ExecuteQuery("delete from mdh_users",null);



            SyncMdhUsers();
            SyncBenutzer();

            SyncHersteller();
            SyncBerater();

            SyncEbook();
            SyncEbookStatistic();

            SyncHauspaket();
            SyncAttachements();
            SyncHauspaketAttribut();
            SyncHauspaketAttributWert();
            SyncHauspaketAttributZuord();
        }

        private void SyncMdhUsers()
        {
            DataTable mysqlResult = ClientMySQL.ExecuteQuery("select id, name, username, email, password from joomla.mdh_users", null);

            foreach (DataRow row in mysqlResult.Rows)
            {
                ClientDB2.ExecuteQuery(new MdhUsers().GetInsertString(row, DatabaseType.DB2), null);
            }
        }

        private void SyncBenutzer()
        {
            DataTable mysqlResult = ClientMySQL.ExecuteQuery("select * from joomla.benutzer", null);

            foreach (DataRow row in mysqlResult.Rows)
            {
                ClientDB2.ExecuteQuery(new Benutzer().GetInsertString(row, DatabaseType.DB2), null);
            }
        }
        private void SyncHersteller()
        {
            DataTable mysqlResult = ClientMySQL.ExecuteQuery("select * from joomla.hersteller", null);

            foreach (DataRow row in mysqlResult.Rows)
            {
                ClientDB2.ExecuteQuery(new Hersteller().GetInsertString(row, DatabaseType.DB2), null);
            }
        }

        private void SyncBerater()
        {
            DataTable mysqlResult = ClientMySQL.ExecuteQuery("select * from joomla.berater", null);

            foreach (DataRow row in mysqlResult.Rows)
            {
                ClientDB2.ExecuteQuery(new Berater().GetInsertString(row, DatabaseType.DB2), null);
            }
        }

        private void SyncEbook()
        {
            DataTable mysqlResult = ClientMySQL.ExecuteQuery("select * from joomla.ebook", null);

            foreach (DataRow row in mysqlResult.Rows)
            {
                ClientDB2.ExecuteQuery(new Ebook().GetInsertString(row, DatabaseType.DB2), null);
            }
        }
        private void SyncEbookStatistic()
        {
            DataTable mysqlResult = ClientMySQL.ExecuteQuery("select * from joomla.ebook_statistic", null);

            foreach (DataRow row in mysqlResult.Rows)
            {
                ClientDB2.ExecuteQuery(new EbookStatistic().GetInsertString(row, DatabaseType.DB2), null);
            }
        }

        private void SyncHauspaket()
        {
            DataTable mysqlResult = ClientMySQL.ExecuteQuery("select * from joomla.hauspaket", null);

            foreach (DataRow row in mysqlResult.Rows)
            {
                ClientDB2.ExecuteQuery(new Hauspaket().GetInsertString(row, DatabaseType.DB2), null);
            }
        }

        private void SyncAttachements()
        {
            DataTable mysqlResult = ClientMySQL.ExecuteQuery("select * from joomla.attachements", null);

            foreach (DataRow row in mysqlResult.Rows)
            {
                ClientDB2.ExecuteQuery(new Attachements().GetInsertString(row, DatabaseType.DB2), null);
            }
        }

        private void SyncHauspaketAttributWert()
        {
            DataTable mysqlResult = ClientMySQL.ExecuteQuery("select * from joomla.hauspaket_attribut_wert", null);

            foreach (DataRow row in mysqlResult.Rows)
            {
                ClientDB2.ExecuteQuery(new HauspaketAttributWert().GetInsertString(row, DatabaseType.DB2), null);
            }
        }

        private void SyncHauspaketAttribut()
        {
            DataTable mysqlResult = ClientMySQL.ExecuteQuery("select * from joomla.hauspaket_attribut", null);

            foreach (DataRow row in mysqlResult.Rows)
            {  
                ClientDB2.ExecuteQuery(new HauspaketAttribut().GetInsertString(row, DatabaseType.DB2),null);
            }
        }
        private void SyncHauspaketAttributZuord()
        {
            DataTable mysqlResult = ClientMySQL.ExecuteQuery("select * from joomla.hauspaket_attribut_zuord", null);

            foreach (DataRow row in mysqlResult.Rows)
            {
                ClientDB2.ExecuteQuery(new HauspaketAttributZuord().GetInsertString(row, DatabaseType.DB2), null);
            }
        }
    }
}
