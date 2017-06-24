using System;
using System.Collections.Generic;
using System.Data;
using System.Data.Common;
using System.Data.Entity;
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
using System.Globalization;

namespace SynchronisationDataManager
{
    public class DataManager
    {
        DatabaseClient ClientMySQL;
        DatabaseClient ClientDB2;

        public void SaveHauspaket(HauspaketDTO hauspaket)
        {
           
            if(hauspaket.HauspaketId.GetValueOrDefault() == 0)
            {
                string query = "insert into hauspaket(hauspaket_id,hersteller_id,berater_id,bezeichnung,preis,grundflaeche,wohnflaeche,stockwerke,benutzer_id) values (";
                Table temp = new Hauspaket();

                temp.AddParamPlain(query, "(select max(hauspaket_id)+10 from hauspaket)", Table.DataType.STRING, false);
                temp.AddParamPlain(query, hauspaket.HerstellerId, Table.DataType.NUMERIC, false);
                temp.AddParamPlain(query, hauspaket.BeraterId, Table.DataType.NUMERIC, false);
                temp.AddParamPlain(query, hauspaket.Bezeichnung, Table.DataType.NUMERIC, false);
                temp.AddParamPlain(query, hauspaket.Preis, Table.DataType.NUMERIC, false);
                temp.AddParamPlain(query, hauspaket.Grundflaeche, Table.DataType.NUMERIC, false);
                temp.AddParamPlain(query, hauspaket.Wohnflaeche, Table.DataType.NUMERIC, false);
                temp.AddParamPlain(query, hauspaket.Stockwerke, Table.DataType.NUMERIC, false);
                temp.AddParamPlain(query, hauspaket.BenutzerId, Table.DataType.NUMERIC, false);
            }
            else
            {

            }
        }

        public void FetchSyncEntriesIntoLocalDB()
        {
            Logger.Info("Fetching SyncJn from MySQL...");
            List<Sync_jn> syncListFromMysql = GetAllSyncJnFromMysql();
            Logger.Info("Success! "+syncListFromMysql.Count+" Entries fetched.");

            Logger.Info("Fetching SyncJn from DB2...");
            List<Sync_jn> syncListFromDB2 = GetAllSyncJnFromDB2();
            Logger.Info("Success! " + syncListFromDB2.Count + " Entries fetched.");

            List<Sync_jn> syncListTotal = new List<Sync_jn>();
            syncListTotal.AddRange(syncListFromMysql);
            syncListTotal.AddRange(syncListFromDB2);

            SynchronisationDatabaseEntities5 db = new SynchronisationDatabaseEntities5();
            db.Sync_jn.AddRange(syncListTotal);
            Logger.Info("Fetched " + syncListTotal.Count + " Entries into local DB");
            db.SaveChanges();

            List<SyncJn> synced = (from syncJn in syncListTotal
                                   select new SyncJn()
                                   {
                                       JnId = syncJn.jn_id,
                                       JnApplication = syncJn.jn_application
                                   }
                                           ).ToList();

            foreach (SyncJn sync in synced)
            {
                try
                {
                    SetSynced(sync, (DatabaseType)Enum.Parse(typeof(DatabaseType), sync.JnApplication));
                }
                catch (Exception e)
                {
                    string message = "Could not translate ENUM: " + sync.JnApplication;
                    Logger.Error(message);
                    AddErrorLog(message);
                }
            }
        }   
        
        private void AddErrorLog(string message)
        {
            DatabaseClientFactory.GetClient(DatabaseType.MYSQL).ExecuteQuery("insert into error_log (log_message) values ('"+message+"')", null);
        }    
        public void SyncFromLocal()
        {
            List<SyncJn> syncJnFromLocal = GetAllSyncJnFromLocal();
            int counter = 1;
            int syncCount = syncJnFromLocal.Count;

            Logger.Info("Local Sync entries found: " + syncCount);

            foreach (SyncJn sync in syncJnFromLocal)
            {
                Logger.Info("Syncing " + counter + "/" + syncCount+" Table: "+sync.JnTable+" Operation: "+sync.JnOperation);

                DatabaseType to;
                DatabaseType from;
                SetDatabases(sync.JnApplication, out from, out to);

                DeactivateTrigger(to);

                List<ColumnProperty> properties = new List<ColumnProperty>();
                switch (sync.JnTable)
                {
                    case "EBOOK_STATISTIC":
                        AddColumnProperty(ref properties, "statistik_id", Table.DataType.NUMERIC, 0);
                        AddColumnProperty(ref properties, "statistik_typ", Table.DataType.STRING, 1);
                        AddColumnProperty(ref properties, "benutzer_id", Table.DataType.NUMERIC, 2);
                        AddColumnProperty(ref properties, "ebook_id", Table.DataType.NUMERIC,3);
                        SyncEntry(sync, new EbookStatistic(), properties, from, to);

                        break;
                    case "MDH_USERS":
                        AddColumnProperty(ref properties, "id", Table.DataType.NUMERIC, 0);
                        AddColumnProperty(ref properties, "name", Table.DataType.STRING, 1);
                        AddColumnProperty(ref properties, "username", Table.DataType.STRING,2);
                        AddColumnProperty(ref properties, "email", Table.DataType.STRING, 3);
                        AddColumnProperty(ref properties, "password", Table.DataType.STRING, 4);
                        SyncEntry(sync, new MdhUsers(), properties, from, to);
                        break;

                    case "BENUTZER":
                        AddColumnProperty(ref properties, "benutzer_id", Table.DataType.STRING, 1);
                        AddColumnProperty(ref properties, "joomla_user_id", Table.DataType.STRING, 1);
                        SyncEntry(sync, new Benutzer(), properties, from, to);
                        break;

                    case "EBOOK":
                        AddColumnProperty(ref properties, "ebook_id", Table.DataType.STRING, 0);
                        AddColumnProperty(ref properties, "titel", Table.DataType.STRING, 1);
                        AddColumnProperty(ref properties, "autor", Table.DataType.STRING, 2);
                        AddColumnProperty(ref properties, "erscheinungsdatum", Table.DataType.DATETIME, 3);
                        AddColumnProperty(ref properties, "auflage", Table.DataType.STRING, 4);
                        AddColumnProperty(ref properties, "content", Table.DataType.STRING, 6);
                        AddColumnProperty(ref properties, "mimetype", Table.DataType.STRING, 7);
                        AddColumnProperty(ref properties, "size", Table.DataType.NUMERIC, 8);
                       // AddColumnProperty(ref properties, "active", Table.DataType.NUMERIC, 9);
                        SyncEntry(sync, new Ebook(), properties, from, to);
                        break;

                    case "BERATER":
                        AddColumnProperty(ref properties, "berater_id", Table.DataType.NUMERIC, 0);
                        AddColumnProperty(ref properties, "hersteller_id", Table.DataType.NUMERIC, 1);
                        AddColumnProperty(ref properties, "benutzer_id", Table.DataType.NUMERIC, 2);
                        AddColumnProperty(ref properties, "bild", Table.DataType.STRING, 3);
                        SyncEntry(sync, new Berater(), properties, from, to);
                        break;

                    case "HERSTELLER":
                        AddColumnProperty(ref properties, "hersteller_id", Table.DataType.NUMERIC, 0);
                        AddColumnProperty(ref properties, "name", Table.DataType.STRING, 1);
                        SyncEntry(sync, new Berater(), properties, from, to);
                        break;

                    case "HAUSPAKET":
                        AddColumnProperty(ref properties, "hauspaket_id", Table.DataType.NUMERIC, 0);
                        AddColumnProperty(ref properties, "hersteller_id", Table.DataType.NUMERIC, 1);
                        AddColumnProperty(ref properties, "berater_id", Table.DataType.NUMERIC, 2);
                        AddColumnProperty(ref properties, "bezeichnung", Table.DataType.STRING, 3);
                        AddColumnProperty(ref properties, "preis", Table.DataType.NUMERIC, 4);
                        AddColumnProperty(ref properties, "grundflaeche", Table.DataType.NUMERIC, 5);
                        AddColumnProperty(ref properties, "wohnflaeche", Table.DataType.NUMERIC, 6);
                        AddColumnProperty(ref properties, "stockwerke", Table.DataType.NUMERIC, 7);
                        AddColumnProperty(ref properties, "benutzer_id", Table.DataType.NUMERIC, 8);
                        SyncEntry(sync, new Hauspaket(), properties, from, to);
                        break;

                    case "ATTACHEMENTS":
                        AddColumnProperty(ref properties, "attachement_id", Table.DataType.NUMERIC, 0);
                        AddColumnProperty(ref properties, "filename", Table.DataType.STRING, 1);
                        AddColumnProperty(ref properties, "bezeichnung", Table.DataType.STRING, 2);
                        AddColumnProperty(ref properties, "size", Table.DataType.NUMERIC, 3);
                        AddColumnProperty(ref properties, "mimetype", Table.DataType.STRING, 4);
                        AddColumnProperty(ref properties, "hauspaket_id", Table.DataType.NUMERIC, 5);
                        SyncEntry(sync, new Attachements(), properties, from, to);
                        break;

                    case "HAUSPAKET_ATTRIBUT_WERT":
                        AddColumnProperty(ref properties, "wert_id", Table.DataType.NUMERIC, 0);
                        AddColumnProperty(ref properties, "attribut_id", Table.DataType.NUMERIC, 1);
                        AddColumnProperty(ref properties, "wert_text", Table.DataType.STRING, 2);
                        AddColumnProperty(ref properties, "wert_ordnung", Table.DataType.NUMERIC, 3);
                        SyncEntry(sync, new HauspaketAttributWert(), properties, from, to);
                        break;

                    case "HAUSPAKET_ATTRIBUT":
                        AddColumnProperty(ref properties, "attribut_id", Table.DataType.NUMERIC, 0);
                        AddColumnProperty(ref properties, "attribut_typ", Table.DataType.STRING, 1);
                        AddColumnProperty(ref properties, "attribut_typ_anzeige", Table.DataType.STRING, 2);
                        SyncEntry(sync, new HauspaketAttribut(), properties, from, to);
                        break;

                    case "HAUSPAKET_ATTRIBUT_ZUORD":
                        AddColumnProperty(ref properties, "hauspaket_id", Table.DataType.NUMERIC, 0);
                        AddColumnProperty(ref properties, "wert_id", Table.DataType.NUMERIC, 1);
                        SyncEntry(sync, new HauspaketAttributZuord(), properties, from, to);
                        break;

                    case "TERMIN":
                        AddColumnProperty(ref properties, "termin_id", Table.DataType.NUMERIC, 0);
                        AddColumnProperty(ref properties, "benutzer_id", Table.DataType.NUMERIC, 1);
                        AddColumnProperty(ref properties, "hauspaket_id", Table.DataType.NUMERIC, 2);
                        AddColumnProperty(ref properties, "endtime", Table.DataType.DATETIME, 3);
                        AddColumnProperty(ref properties, "berater_id", Table.DataType.NUMERIC, 4);
                        AddColumnProperty(ref properties, "starttime", Table.DataType.DATETIME, 5);
                        AddColumnProperty(ref properties, "description", Table.DataType.STRING, 6);
                        SyncEntry(sync, new Termin(), properties, from, to);
                        break;

                    case "HAUSKAUF":
                        AddColumnProperty(ref properties, "hauskauf_id", Table.DataType.NUMERIC, 0);
                        AddColumnProperty(ref properties, "termin_id", Table.DataType.NUMERIC, 1);
                        AddColumnProperty(ref properties, "kaufpreis", Table.DataType.STRING, 2);
                        AddColumnProperty(ref properties, "zahlungsvereinbarung", Table.DataType.STRING, 3);
                        AddColumnProperty(ref properties, "anmerkungen", Table.DataType.STRING, 4);
                        AddColumnProperty(ref properties, "kaufdatum", Table.DataType.DATETIME, 5);
                        AddColumnProperty(ref properties, "status", Table.DataType.STRING, 6);
                        AddColumnProperty(ref properties, "message", Table.DataType.STRING, 6);
                        SyncEntry(sync, new Hauskauf(), properties, from, to);
                        break;
                }

                SetSynced(sync, DatabaseType.LOCAL);
                ActivateTrigger(to);

                counter++;
            }
            Logger.Info("Finished Sync!");
        }

        private void DeactivateTrigger(DatabaseType inDatabase)
        {
            DatabaseClient client =  DatabaseClientFactory.GetClient(inDatabase);
            client.ExecuteQuery("update trigger_enabled set trigger_enabled = 0 where trigger_enabled = 1", null);
        }
        private void ActivateTrigger(DatabaseType inDatabase)
        {
            DatabaseClient client = DatabaseClientFactory.GetClient(inDatabase);
            client.ExecuteQuery("update trigger_enabled set trigger_enabled = 1 where trigger_enabled = 0", null);
        }

        private void SetDatabases(string application, out DatabaseType from, out DatabaseType to)
        {
            if (application.Equals("MYSQL"))
            {
                from = DatabaseType.MYSQL;
                to = DatabaseType.DB2;
            }
            else
            {
                to = DatabaseType.MYSQL;
                from = DatabaseType.DB2;
            }
        }

        private void AddColumnProperty(ref List<ColumnProperty> properties, string column, Table.DataType dataType, int index)
        {
            properties.Add(new ColumnProperty()
            {
                ColumnName = column,
                dataType = dataType,
                index = index
            });
        }

        private void SyncEntry(SyncJn sync, Table obj, List<ColumnProperty> updateColumnProperties, DatabaseType from, DatabaseType to)
        {
            switch(sync.JnOperation)
            {
                case "INSERT":
                    try
                    {
                        DataRow row;
                        if (obj.GetType().Equals(typeof(HauspaketAttributZuord)))
                        {
                            row = GetSingleDataRowForMultiPk(sync.JnChangesetJson,sync.JnTable, "hauspaket_id","wert_id", from);
                        }
                        else
                        {
                            row = GetSingleDataRow(sync.JnPk, sync.JnTable, obj.GetPrimaryKeyColumn(), from);
                        }
                        DatabaseClientFactory.GetClient(to).ExecuteQuery(obj.GetInsertString(row, to), null);
                    }
                    catch(Exception e)
                    {

                        string message = "Error inserting " + obj.GetTableName() + " from " + from + ": " + e.Message + " on JN ID: " + sync.JnId;
                        Logger.Error(message);
                        AddErrorLog(message);
                    }                   
                    break;
                case "UPDATE":
                    try
                    {
                        DataRow row;
                        if (obj.GetType().Equals(typeof(HauspaketAttributZuord)))
                        {
                            row = GetSingleDataRowForMultiPk(sync.JnChangesetJson, sync.JnTable, "hauspaket_id", "wert_id", from);
                        }
                        else
                        {
                            row = GetSingleDataRow(sync.JnPk, sync.JnTable, obj.GetPrimaryKeyColumn(), from);
                        }

                        string query = obj.GetUpdateString();

                        ColumnProperty last = updateColumnProperties.Last();
                        foreach (ColumnProperty columnProperty in updateColumnProperties)
                        {
                            query = Table.AddUpdateParam(query, columnProperty.ColumnName, row[columnProperty.index], to, columnProperty.dataType, columnProperty.Equals(last));
                        }

                        if (obj.GetType().Equals(typeof(HauspaketAttributZuord)))
                        {
                            string[] parts = sync.JnChangesetJson.Split(';');

                            Nullable<int> pk1 = new Nullable<int>(Int32.Parse(parts[2]));
                            Nullable<int> pk2 = new Nullable<int>(Int32.Parse(parts[3]));
                            query = query + " where hauspaket_id = "+pk1.Value+" and wert_id = "+pk2;
                        }
                        else
                        {
                            query = query + " where " + obj.GetWherePk(sync.JnPk.Value);
                        }

                    DatabaseClientFactory.GetClient(to).ExecuteQuery(query,null);
                    }
                    catch (Exception e)
                    {

                        string message = "Error updating " + obj.GetTableName() + " from " + from + ": " + e.Message + " on JN ID: " + sync.JnId;
                        Logger.Error(message);
                        AddErrorLog(message);
                    }
                    break;
                case "DELETE":
                    try
                    {
                        if (obj.GetType().Equals(typeof(HauspaketAttributZuord)))
                        {
                            string[] parts = sync.JnChangesetJson.Split(';');

                            Nullable<int> pk1 = new Nullable<int>(Int32.Parse(parts[0]));
                            Nullable<int> pk2 = new Nullable<int>(Int32.Parse(parts[1]));

                            DatabaseClientFactory.GetClient(to).ExecuteQuery("delete from hauspaket_attribut_zuord where hauspaket_id = "+pk1+" and wert_id = "+pk2, null);
                        }
                        else
                        {
                            DatabaseClientFactory.GetClient(to).ExecuteQuery(obj.getDeleteString(sync.JnPk.Value), null);
                        }
                    }
                    catch (Exception e)
                    {
                        string message = "Error deleting  " + obj.GetTableName() + " from " + from + ": " + e.Message + " on JN ID: " + sync.JnId;
                        Logger.Error(message);
                        AddErrorLog(message);
                    }
                    break;
            }
            SetSynced(sync, from);
        }

        private void SetSynced(SyncJn sync, DatabaseType type)
        {
            if (type.Equals(DatabaseType.LOCAL))
            {
                SynchronisationDatabaseEntities5 db = new SynchronisationDatabaseEntities5();
                try
                {
                    Sync_jn localSyncEntry = (from syncJn in db.Sync_jn where syncJn.jn_id.Equals(sync.JnId.Value) select syncJn).Single<Sync_jn>();
                    db.Sync_jn.Remove(localSyncEntry);
                    db.SaveChanges();
                }
                catch(Exception e)
                {
                    string message = "Error updating local database: "+e.Message;
                    Logger.Error(message);
                    AddErrorLog(message);
                }
              
                return;
            }
            Logger.Info("Setting Entry with ID " + sync.JnId + " synced in " + type);
            DatabaseClientFactory.GetClient(type).ExecuteQuery("update sync_jn set jn_synced = " + 1 + " where jn_id = " + sync.JnId,null);
        }

        private DataRow GetSingleDataRow(Nullable<int> pk, string tableName, string pkColumn, DatabaseType type)
        {
            DatabaseClient currentClient = DatabaseClientFactory.GetClient(type);
            DataTable table = currentClient.ExecuteQuery("select * from "+ tableName + " where "+pkColumn+" = " + pk, null);
            return table.Rows[0];
        }
        private DataRow GetSingleDataRowForMultiPk(string json, string tableName, string pkColumn1, string pkColumn2, DatabaseType type)
        {
            string[] parts = json.Split(';');

            Nullable<int> pk1 = new Nullable<int>(Int32.Parse(parts[0]));
            Nullable<int> pk2 = new Nullable<int>(Int32.Parse(parts[1]));
            DatabaseClient currentClient = DatabaseClientFactory.GetClient(type);
            DataTable table = currentClient.ExecuteQuery("select * from " + tableName + " where " + pkColumn1 + " = " + pk1 +" and "+pkColumn2+" = " +pk2, null);
            return table.Rows[0];
        }

        private List<SyncJn> GetAllSyncJnFromLocal()
        {
            byte unsynced = Convert.ToByte(HandleInt("0"));
            SynchronisationDatabaseEntities5 db = new SynchronisationDatabaseEntities5();
            return (from syncJn in db.Sync_jn where syncJn.jn_synced.Equals(unsynced) orderby syncJn.jn_timestamp descending, syncJn.jn_id ascending
                    select new SyncJn()
            {
                JnId = syncJn.jn_id,
                JnTable = syncJn.jn_table,
                JnPk = syncJn.jn_pk,
                JnOperation = syncJn.jn_operation,
                JnTimestamp = "",
                JnApplication = syncJn.jn_application,
                JnChangesetJson = syncJn.jn_changeset_json,
                JnSynced = syncJn.jn_synced
            }).ToList<SyncJn>();
        }
        private List<Sync_jn> GetAllSyncJnFromMysql()
        {
            ClientMySQL = DatabaseClientFactory.GetClient(DatabaseType.MYSQL);
            DataTable syncJnTable = ClientMySQL.ExecuteQuery("select * from sync_jn where jn_synced = 0 order by jn_timestamp desc, jn_id asc", null);

            var resultSet = from syncJn in syncJnTable.AsEnumerable()
                            select new Sync_jn()
                            {
                                jn_id = HandleInt(syncJn[0].ToString()).GetValueOrDefault(),
                                jn_sync_id = Guid.NewGuid(),
                                jn_table = syncJn[1].ToString(),
                                jn_timestamp = DateTime.ParseExact(syncJn[2].ToString(), "dd.MM.yyyy HH:mm:ss", CultureInfo.InvariantCulture),
                                jn_pk = HandleInt(syncJn[3].ToString()).GetValueOrDefault(),
                                jn_operation = syncJn[4].ToString(),
                                jn_synced = Convert.ToByte(HandleInt(syncJn[5].ToString()).GetValueOrDefault()),
                                jn_changeset_json = syncJn[6] == null ? "EMPTY" : syncJn[6].ToString(),
                                jn_application = "MYSQL"
                            };

            return resultSet.ToList<Sync_jn>();
        }
        private List<Sync_jn> GetAllSyncJnFromDB2()
        {
            ClientDB2 = DatabaseClientFactory.GetClient(DatabaseType.DB2);
            DataTable syncJnTable = ClientDB2.ExecuteQuery("select * from sync_jn where jn_synced = 0 order by jn_timestamp desc, jn_id asc", null);

            var resultSet = from syncJn in syncJnTable.AsEnumerable()
                            select new Sync_jn()
                            {
                                jn_id = HandleInt(syncJn[0].ToString()).GetValueOrDefault(),
                                jn_sync_id = Guid.NewGuid(),
                                jn_table = syncJn[1].ToString(),
                                jn_timestamp = DateTime.ParseExact(syncJn[2].ToString(), "dd.MM.yyyy HH:mm:ss", CultureInfo.InvariantCulture),
                                jn_pk = HandleInt(syncJn[3].ToString()).GetValueOrDefault(),
                                jn_operation = syncJn[4].ToString(),
                                jn_synced = Convert.ToByte(HandleInt(syncJn[5].ToString()).GetValueOrDefault()),
                                jn_changeset_json = syncJn[6] == null ? "EMPTY" : syncJn[6].ToString(),
                                jn_application = "DB2"
                            };

            return resultSet.ToList<Sync_jn>();
        }
        public List<HauspaketAttribut> GetAllHauspaketAttributInsert()
        {
            ClientDB2 = DatabaseClientFactory.GetClient(DatabaseType.DB2);
            DataTable hauspaketAttributTable = ClientDB2.ExecuteQuery(new HauspaketAttribut().GetSelectAllString(),null);

            var resultSet = from hauspaketAttribut in hauspaketAttributTable.AsEnumerable()
                     select new HauspaketAttribut()
                     {
                         SyncOperation = "INSERT",
                         AttributId = HandleInt(hauspaketAttribut[0].ToString()),
                         AttributTyp = hauspaketAttribut[1].ToString(),
                         AttributTypAnzeige  = "" + hauspaketAttribut[2]
                     };
            
            return resultSet.ToList<HauspaketAttribut>();
        }

        public List<HauspaketAttributWert> GetAllHauspaketAttributWertInsert()
        {
            ClientDB2 = DatabaseClientFactory.GetClient(DatabaseType.DB2);
            DataTable hauspaketAttributWertTable = ClientDB2.ExecuteQuery(new HauspaketAttributWert().GetSelectAllString(), null);

            var resultSet = from hauspaketAttributWert in hauspaketAttributWertTable.AsEnumerable()
                            select new HauspaketAttributWert()
                            {
                                SyncOperation = "INSERT",
                                WertId = HandleInt(hauspaketAttributWert[0].ToString()),
                                AttributId = HandleInt(hauspaketAttributWert[1].ToString()),
                                WertText = hauspaketAttributWert[2].ToString(),
                                WertOrdnung = HandleInt(hauspaketAttributWert[3].ToString()),
                                Archived = hauspaketAttributWert[4].ToString()
                            };

            return resultSet.ToList<HauspaketAttributWert>();
        }
        public List<HauspaketAttributRegel> GetAllHauspaketAttributRegelInsert()
        {
            ClientDB2 = DatabaseClientFactory.GetClient(DatabaseType.DB2);
            DataTable hauspaketAttributRegelTable = ClientDB2.ExecuteQuery(new HauspaketAttributRegel().GetSelectAllString(), null);

            var resultSet = from hauspaketAttributRegel in hauspaketAttributRegelTable.AsEnumerable()
                            select new HauspaketAttributRegel()
                            {
                                SyncOperation = "INSERT",
                                RegelId = HandleInt(hauspaketAttributRegel[0].ToString()),
                                RegelAttributLeftId = HandleInt(hauspaketAttributRegel[1].ToString()),
                                RegelAttributRightId = HandleInt(hauspaketAttributRegel[2].ToString()),
                                RegelPreisModifikator = HandleDouble(hauspaketAttributRegel[3].ToString()),
                                RegelErlaubt = hauspaketAttributRegel[4].ToString(),
                            };

            return resultSet.ToList<HauspaketAttributRegel>();
        }

        public List<HauspaketAttributZuord> GetAllHauspaketAttributZuordInsert()
        {
            ClientDB2 = DatabaseClientFactory.GetClient(DatabaseType.DB2);
            DataTable hauspaketAttributZuordTable = ClientDB2.ExecuteQuery(new HauspaketAttributZuord().GetSelectAllString(), null);

            var resultSet = from hauspaketAttributZuord in hauspaketAttributZuordTable.AsEnumerable()
                            select new HauspaketAttributZuord()
                            {
                                SyncOperation = "INSERT",
                                HauspaketId = HandleInt(hauspaketAttributZuord[0].ToString()),
                                WertId = HandleInt(hauspaketAttributZuord[1].ToString())
                            };

            return resultSet.ToList<HauspaketAttributZuord>();
        }

        public List<Hersteller> GetAllHerstellerInsert()
        {
            ClientDB2 = DatabaseClientFactory.GetClient(DatabaseType.DB2);
            DataTable herstellerTable = ClientDB2.ExecuteQuery(new Hersteller().GetSelectAllString(), null);

            var resultSet = from hersteller in herstellerTable.AsEnumerable()
                            select new Hersteller()
                            {
                                SyncOperation = "INSERT",
                                HerstellerId = HandleInt(hersteller[0].ToString()),
                                Name = hersteller[0].ToString()
                            };

            return resultSet.ToList<Hersteller>();
        }

        public List<Berater> GetAllBeraterInsert()
        {
            ClientDB2 = DatabaseClientFactory.GetClient(DatabaseType.DB2);
            DataTable beraterTable = ClientDB2.ExecuteQuery(new Berater().GetSelectAllString(), null);

            var resultSet = from berater in beraterTable.AsEnumerable()
                            select new Berater()
                            {
                                SyncOperation = "INSERT",
                                BeraterId = HandleInt(berater[0].ToString()),
                                HerstellerId = HandleInt(berater[1].ToString()),
                                BenutzerId = HandleInt(berater[2].ToString()),
                                Bild = berater[3].ToString()
                            };

            return resultSet.ToList<Berater>();
        }

        public List<Hauspaket> GetAllHauspaketInsert()
        {
            ClientDB2 = DatabaseClientFactory.GetClient(DatabaseType.DB2);
            DataTable hauspaketTable = ClientDB2.ExecuteQuery(new Hauspaket().GetSelectAllString(), null);

            var resultSet = from hauspaket in hauspaketTable.AsEnumerable()
                            select new Hauspaket()
                            {
                                SyncOperation = "INSERT",
                                HauspaketId = HandleInt(hauspaket[0].ToString()),
                                HerstellerId = HandleInt(hauspaket[1].ToString()),
                                BeraterId = HandleInt(hauspaket[2].ToString()),
                                Bezeichnung = hauspaket[3].ToString(),
                                Preis = HandleDouble(hauspaket[4].ToString()),
                                Grundflaeche = HandleDouble(hauspaket[5].ToString()),
                                Wohnflaeche = HandleDouble(hauspaket[6].ToString()),
                                Stockwerke = HandleInt(hauspaket[7].ToString()),
                                BenutzerId = HandleInt(hauspaket[8].ToString()),
                                Archived = hauspaket[9].ToString()
                            };

            return resultSet.ToList<Hauspaket>();
        }
        public List<Attachements> GetAllAttachementsInsert()
        {
            ClientDB2 = DatabaseClientFactory.GetClient(DatabaseType.DB2);
            DataTable attachementsTable = ClientDB2.ExecuteQuery(new Attachements().GetSelectAllString(), null);

            var resultSet = from attachements in attachementsTable.AsEnumerable()
                            select new Attachements()
                            {
                                SyncOperation = "INSERT",
                                AttachementId = HandleInt(attachements[0].ToString()),
                                Filename = attachements[1].ToString(),
                                Bezeichnung = attachements[2].ToString(),
                                Size = HandleInt(attachements[3].ToString()),
                                Mimetype = attachements[4].ToString(),
                                HauspaketId = HandleInt(attachements[5].ToString())
                            };

            return resultSet.ToList<Attachements>();
        }

        public void FullSyncMySQLToDB2()
        {
            ClientDB2 = DatabaseClientFactory.GetClient(DatabaseType.DB2);
            ClientMySQL = DatabaseClientFactory.GetClient(DatabaseType.MYSQL);

            ClientDB2.ExecuteQuery("delete from hauskauf", null);
            ClientDB2.ExecuteQuery("delete from termin", null);

            ClientDB2.ExecuteQuery("delete from berater", null);

            ClientDB2.ExecuteQuery("delete from ebook_statistic", null);
            ClientDB2.ExecuteQuery("delete from ebook", null);

            ClientDB2.ExecuteQuery("delete from attachements", null);

            ClientDB2.ExecuteQuery("delete from hauspaket_attribut_regel", null);
            ClientDB2.ExecuteQuery("delete from hauspaket_attribut_zuord", null);
            ClientDB2.ExecuteQuery("delete from hauspaket", null);
            ClientDB2.ExecuteQuery("delete from hauspaket_attribut_wert", null);
            ClientDB2.ExecuteQuery("delete from hauspaket_attribut", null);

            ClientDB2.ExecuteQuery("delete from hersteller", null);
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
            SyncHauspaketAttributRegel();
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
        private void SyncHauspaketAttributRegel()
        {
            DataTable mysqlResult = ClientMySQL.ExecuteQuery("select * from joomla.hauspaket_attribut_regel", null);

            foreach (DataRow row in mysqlResult.Rows)
            {
                ClientDB2.ExecuteQuery(new HauspaketAttributRegel().GetInsertString(row, DatabaseType.DB2), null);
            }
        }
        private void SyncHauskauf()
        {
            DataTable mysqlResult = ClientMySQL.ExecuteQuery("select * from joomla.hauskauf", null);

            foreach (DataRow row in mysqlResult.Rows)
            {
                ClientDB2.ExecuteQuery(new Termin().GetInsertString(row, DatabaseType.DB2), null);
            }
        }
        private void SyncTermin()
        {
            DataTable mysqlResult = ClientMySQL.ExecuteQuery("select * from joomla.termin", null);

            foreach (DataRow row in mysqlResult.Rows)
            {
                ClientDB2.ExecuteQuery(new Termin().GetInsertString(row, DatabaseType.DB2), null);
            }
        }

        private Nullable<int> HandleInt(string value)
        {
            int ret;
            if(Int32.TryParse(value,out ret))
            {
                return ret;
            }
            return null;
        }
        private Nullable<double> HandleDouble(string value)
        {
            double ret;
            if (Double.TryParse(value, out ret))
            {
                return ret;
            }
            return null;
        }
    }
}
