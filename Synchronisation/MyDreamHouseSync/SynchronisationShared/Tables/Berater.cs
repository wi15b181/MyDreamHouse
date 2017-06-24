using System;
using System.Collections.Generic;
using System.Data;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using static SynchronisationShared.SharedEnums;

namespace SynchronisationDataManager.Tables
{
    public class Berater : Table
    {
        public Nullable<int> BeraterId { get; set; }
        public Nullable<int> HerstellerId { get; set; }
        public Nullable<int> BenutzerId { get; set; }
        public string Bild { get; set; }
        public override string GetInsertString(DataRow row, DatabaseType type)
        {
            string query = "insert into " + GetTableName() + " (berater_id,hersteller_id,benutzer_id,bild) values (";

            query = AddParam(query, row, 0, DataType.NUMERIC, false);
            query = AddParam(query, row, 1, DataType.NUMERIC, false);
            query = AddParam(query, row, 2, DataType.NUMERIC, false);
            query = AddParam(query, row, 3, DataType.STRING, true);

            return query;
        }

        public override string GetTableName()
        {
            return "berater";
        }

        public override string GetPrimaryKeyColumn()
        {
            return "berater_id";
        }
    }
}
